/****************************** INSERT & UPDATE ***************************************/
function state_cu(state_id,action)
{
	
       var forms = document.getElementsByClassName('was-validated');
		var validation = Array.prototype.filter.call(forms, function(form) {
		if (form.checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
		}else{
			
			format=$("form").serialize()+"&state_id="+state_id+"&action="+action;
			jQuery.ajax({
				type: "POST",
				url: "state/curd.php",
				data: format,
				success: function(msg){ 
				var obj =JSON.parse(msg);
				if(obj.msg=='3')
				{	
				  alert("Already Exist");
				}
				else
				{
				alert(obj.msg);
				window.location.href="index.php?file=state/list";
				}
				
				}
			});
		}
	});

}
/*****************************  Delete  **********************************/
function del(state_id)
{
	value=confirm("Are Sure You Want Delete?");
	if(value){
	  jQuery.ajax({
			type: "POST",
			url: "state/curd.php",
			data: "state_id="+state_id+"&action="+"Delete",
			success: function(msg){ 
				var obj =JSON.parse(msg);
				if(obj.msg == 'delete')
				{
					notify('deleted');;
					console.log(msg);
					location.reload();
				}


			}});
	}

}

/*****************************************************************************/