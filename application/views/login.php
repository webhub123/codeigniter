<div class="container col-sm-offset-4 col-sm-4">

    <div class="ui-widget" id="error" style="margin-bottom: 10px;">
        <div class="ui-state-error ui-corner-all" style="padding:5px;">
            <span class="glyphicon glyphicon-exclamation-sign" ></span>
            <strong class="error_message">...</strong>
        </div>
    </div>

    <div class="ui-widget" id="correct" style="margin-bottom: 10px;">
        <div class="ui-state-highlight ui-corner-all" style="padding:5px;">
            <span class="glyphicon glyphicon-info-sign" ></span>
            <strong  class="correct_message">...</strong>
        </div> 
    </div>


    <h3>Login </h3>
    <hr/>
    <div class="form-group">
        <label >Username:</label>
        <input type="text" class="form-control" id="username"  />
    </div>
    <div class="form-group">
        <label >Password:</label>
        <input type="password" class="form-control" id="password"  />
    </div>
    <button class="btn btn-primary">Log In</button>
</div>


<script type="text/javascript">
$(function() {


    function error(validate) {
        if(validate == "hide") {
            $('#error').hide();
        }else {
            $('#correct').hide();
            $('#error').show();
            $('.error_message').text(validate);         
        }
    }

    function correct(validate){
        if(validate == "hide") {
            $('#correct').hide();
        }else {
            $('#error').hide();
            $('#correct').show();
            $('.correct_message').text(validate);           
        }
    }    

    error('hide');
    correct('hide');


});
</script>
