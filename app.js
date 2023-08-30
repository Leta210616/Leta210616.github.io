$('#tarea').focus();

function cargar_tareas(estado=null){
			$.ajax({
				url:'tareas_ajax.php?action=ajax&estado='+estado,
				 beforeSend: function(objeto){
				 $('#loader').html('Cargando...');
			  },
				success:function(data){
					$(".task-box").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}
		cargar_tareas();
		
	function eliminar_tarea(id) {
		if (confirm('Realmente deseas eliminar esta tarea?')){
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'tareas_ajax.php?action=ajax&delete='+id,
				 beforeSend: function(objeto){
				 $('#loader').html('Cargando...');
			  },
				success:function(data){
					$(".task-box").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
			
		}
       
    }
	
	function actualizar_estado(id){
		var txt_estado=0;
		if( $('#'+id).is(':checked') ){
			txt_estado=1;
		}
		$.ajax({
				url:'tareas_ajax.php?action=ajax&update='+id+'&txt_estado='+txt_estado,
				 success:function(data){
					$(".task-box").html(data).fadeIn('slow');
					$('#loader').html('');
				}
		})
	}
	
	$( "#guardar_tarea" ).submit(function( event ) {
		var parametros = $(this).serialize();
		
		$.ajax({
				type: "get",
				url: "tareas_ajax.php?action=ajax",
				data: parametros,
				 beforeSend: function(objeto){
					$("#loader").html("Mensaje: Cargando...");
				  },
				success: function(datos){
				$(".task-box").html(datos);
				$('#loader').html('');
				$("#tarea").val('');
				$("#id_tarea").val(0);
				$("#tarea").focus();
				
				
			  }
		});
	
		event.preventDefault();
	})
	
	function eliminar_todo(){
		if(confirm('Realmente desea eliminar todas las tareas?')){
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'tareas_ajax.php?action=ajax&delete_all=all',
				 beforeSend: function(objeto){
				 $('#loader').html('Cargando...');
			  },
				success:function(data){
					$(".task-box").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}
	}
		
	function editar_tarea(id,tarea){
		 $("#tarea").val(tarea);
		$("#id_tarea").val(id);
		
		$("#tarea").focus();
		
	}
	
	
	function showMenu(selectedTask) {
		let menuDiv = selectedTask.parentElement.lastElementChild;
		menuDiv.classList.add("show");
		document.addEventListener("click", e => {
			if(e.target.tagName != "I" || e.target != selectedTask) {
				menuDiv.classList.remove("show");
			}
		});
	}