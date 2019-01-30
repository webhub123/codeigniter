<div class="container col-sm-offset-4 col-sm-4">
    <h3>Register Account</h3>
    <hr/>
        <div class="form-group">
            <label >Username:</label>
        
            <input type="text" class="form-control"  id="username"   />
        </div>
       
        <div class="form-group">
            <label >Password:</label>
            
            <input type="password" class="form-control"  id="password"  />
        </div>

        <div class="form-group">
            <label >Re-type Password:</label>
          
            <input type="password" class="form-control"  id="retype"  />
        </div>
        <button  class="btn btn-primary" id="register">Register</button>
</div>

<script>
$(function() {


    $('#register').click(function() {

        var username = $('#username').val();
        var password = $('#password').val();
        var retype = $('#retype').val();

        var data = { username : username, password : password, retype : retype };


        $.ajax({
            data : data
            , type: "POST"
            , url: "<?php echo base_url('Welcome/save_register'); ?>"
            , dataType: 'json'
            , crossOrigin: false
            , beforeSend : function() {
                $(this).prop('disabled',true);
            }        
            , success: function(result) {
                
                $(this).removeAttr('disabled');

                if(result.status == true) {
                    location.reload();
                }

            }
            , failure: function(msg) {
                console.log("Failure to connect to server!");
            }
            , error: function(status) {
                
            }, xhr: function(){
                var xhr = $.ajaxSettings.xhr() ;
                xhr.onprogress = function(evt){ 
                    $("body").css("cursor", "wait"); 
                };  
                xhr.onloadend = function(evt){ 
                    $("body").css("cursor", "default"); 
                };      
                return xhr ;
            }
        });

    });


});
</script>