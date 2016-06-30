var app = {
	
	ajax: {	
		submit: function(e, f, l, u,s,c){
			var check = true;	
			var $validate = $(f);
			check = $validate.parsley().validate();
			var $form = $(e);
			var urlAction = apiurl+$form.attr('action');
			if(check == true)
			{
				$.ajax({
					beforeSend: function(){
						if (typeof(l) == "function") l();
					},
					type: $form.attr('method'),
					url: urlAction,
					data: $form.find(':input,:hidden,textarea').serialize(),
					dataType: 'json',
					success: function(response){
						if(!response.status){
							$('.alert-danger').html(response.message).show();
							setTimeout(function() {
				             $('.alert-danger').html('').hide();
				            }, 1000); 							
						}
						else{
							if(c)
								var msg = c+' '+response.message;
							else
								var msg = response.message;							
							$('.alert-success').html(msg).show();
							if (typeof(u) == "function") u(s);
							$('#ajax-modal').modal('hide');
						}
					}
				});
			}
		}	
	},
	profile:{
        uploadimage:function(obj){
        	var file = $('#fileToUpload')[0].files[0]; 
            file_size = $('#fileToUpload')[0].files[0].size;
            $("#uploadFile").val(obj);
            if(file_size>1048576) {
                $("#file_error").html("File size is greater than 1 MB");  
            } else {
                var ext = $('#fileToUpload')[0].files[0].type;
                ext = ext.split('/');
                if($.inArray(ext[1], ['jpg','jpeg','png']) == -1) {
                  $("#file_error").html("Invalid file type"); 
                } else {
                    var reader = new FileReader();
                    reader.onload = function (e){
                      $("#profileimage").attr('src', reader.result);  
                      $("#image").val(reader.result);      
                      $("#file_error").html("");
                    }
               }
            }
            reader.readAsDataURL(file);
        },
        uploadsign:function(obj){
        	var file = $('#signToUpload')[0].files[0]; 
            file_size = $('#signToUpload')[0].files[0].size;
            $("#uploadSign").val(obj);
            if(file_size>1048576) {
                $("#sign_error").html("File size is greater than 1 MB");  
            } else {
                var ext = $('#signToUpload')[0].files[0].type;
                ext = ext.split('/');
                if($.inArray(ext[1], ['jpg','jpeg','png']) == -1) {
                  $("#sign_error").html("Invalid file type"); 
                } else {
                    var reader = new FileReader();
                    reader.onload = function (e){
                      $("#signimage").attr('src', reader.result);  
                      $("#signature_image").val(reader.result);      
                      $("#sign_error").html("");
                    }
               }
            }
            reader.readAsDataURL(file);
        },
        error:function(obj){
            var title = $(obj).attr('msg');
        	$('.alert-danger').html(title).show();	
        	setTimeout(function() {
		        $(".alert-danger").html('').hide();
		    }, 4000);
        },
        warning:function(obj){
            bootbox.confirm("Are you sure,you want to save the changes?", function(result) {
                if(result){
                    var href = $(obj).attr('title');
                    window.location.href = href;
                } 
            });     
        },  
    } 
}

function gridRefresh(selector)
{
    $('#'+selector).data('kendoGrid').dataSource.read();
    $('#'+selector).data('kendoGrid').refresh();
}
