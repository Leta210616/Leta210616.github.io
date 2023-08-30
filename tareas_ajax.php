<?php

#toma los datos del formulario 
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

  #conexion asincrona con la base de datos
	if($action == 'ajax'){
		include("conexionDB.php");
		$sWhere="";

		#en esta parte se maneja el estado de completado (filtro)
		if (isset($_REQUEST["estado"])){
			$filtrar_estado=mysqli_real_escape_string($link,(strip_tags($_REQUEST["estado"],ENT_QUOTES)));
			if ($filtrar_estado!=null){
				if ($filtrar_estado==0){
					$sWhere=" where estado=0";
				} else if ($filtrar_estado==1){
					$sWhere=" where estado=1";
				} 
			}
		}

    #declaro el nombre de la tabla y el valor id de la tarea
		$sTable = "taks";
		$sWhere .= " order by id desc";
		
    #eliminar tarea
		if (isset($_REQUEST['delete'])){
			$id_tarea=intval($_REQUEST['delete']);
			$delete=mysqli_query($link,"delete from $sTable where id='$id_tarea'");
		}
		
    #editar tarea
		if (isset($_REQUEST['update'])){
			$id_tarea=intval($_REQUEST['update']);
			$txt_estado=intval($_REQUEST['txt_estado']);
			$update=mysqli_query($link,"update $sTable set estado='$txt_estado' where id='$id_tarea'");
		}

    #agregar tarea
		if (isset($_REQUEST['tarea'])){
			$id_tarea=intval($_REQUEST["id_tarea"]);
			$tarea=mysqli_real_escape_string($link,(strip_tags($_REQUEST["tarea"],ENT_QUOTES)));
			if ($id_tarea>0){
				$sql="update tareas set tarea='$tarea' where id='$id_tarea'";
			} else {
				$sql="INSERT INTO `taks` (`id`, `tarea`, `estado`) VALUES (NULL, '$tarea', '0');";
			}
			$insert = mysqli_query($link,$sql);
		}
		
    #eliminar todas las tareas
		if (isset($_REQUEST['delete_all'])){
			$delete=mysqli_query($link,"delete from $sTable ");
		}
		$sql="SELECT * FROM  $sTable $sWhere ";
		$query = mysqli_query($link, $sql);
		$num=mysqli_num_rows($query);
		if ($num>0){
			?>
			
			<?php
      #Marcar tareas como pendiente o completado
      #mysqli_fetch_array es aquel que sirve para ejecutar los cambios(editar, borar, crear) de la base de datos
			while($row=mysqli_fetch_array($query)){
					$estado=$row['estado'];
					if ($estado==0){
						$class='';
					} else {
						$class='checked';
					}
			?>
			<li class="task">
				<label for="${id}">
          <!--aplica el estado ya completa subrayado-->
					<input onclick="actualizar_estado(<?=$row['id']?>)" type="checkbox" id="<?=$row['id']?>" <?=$class;?>>
					<p class="<?=$class;?>"><?=$row['tarea']?></p>
				</label>
				<div class="settings">
					<i onclick="showMenu(this)" class="uil uil-ellipsis-h"></i>
					<ul class="task-menu">

            <!--botones de editar y borrar-->
						<li onclick="editar_tarea('<?=$row['id']?>','<?=$row['tarea']?>')"><i class="uil uil-pen"></i>Editar</li>
						<li onclick="eliminar_tarea('<?=$row['id']?>')"><i class="uil uil-trash"></i>Borrar</li>
					</ul>
				</div>
			</li>
					<?php
			}
		?>
		
		<?php	
			
		}
		
	}
?>       