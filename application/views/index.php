<div class="jumbotron text-center">
  <h2>Public Page</h2>
  <p>Bootstrap 3</p> 
</div>


<script type="text/javascript">
$(function() {

    var index = function() {

        var data = {   };
        
        $.ajax({
            data : data
            , type: "POST"
            , url: "<?php echo base_url('query_controller/get_total_number'); ?>"
            , dataType: 'json'
            , crossOrigin: false
            , beforeSend : function() {
                
            }        
            , success: function(result) {
                


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
    }

    //index();

});
</script>
