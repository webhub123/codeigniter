//autocomplete

    $("#cust_code").autocomplete({
        minLength: 0,
        source: 'url',
        focus: function( event, ui ) {
            return false;
        },
        select: function( event, ui ) {
            $('#customer').val(ui.item.customer_name);
            $(this).val(ui.item.cust_code);
            $("#mailing_add").val(ui.item.address_1);

            return false; 
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .append( "<div>" + item.cust_code + "</div>" )
        .appendTo( ul );
    };   


    //autocomplete with multiple get

        //source: function(req, res) {
            $.ajax({
                url: 'base_url',
                dataType: "json",
                data: {
                    term: req.term,
                    status: $("#status").val()
                },
                success: function( data ) {
                    res( data );
                }
            });           
        //}
    //autocomplete with multiple get

//autocomplete


//.each all check boxes


    $('#mrk_done').click(function () {

        var list = [];

        $(".chk_done:checked").each(function(i){

            list.push($(this).data('time'));
        });

        if(list.length <= 0) {

            swal("No row selected.","","");
            return false;
        }

    });

//.each all check boxes

//searching with keycode

    $('#search').keyup(function(e) {

        var keycode = e.which;
        $('#page').pagination('disable');

        if(keycode == 13) {

            $('#btn_search').click();

        }

        if(jQuery.trim($(this).val()).length <= 0) {

            $('#btn_search').click();
        }

    });

//searching with keycode


//dom/document event handler

    $(document).on('click','#return_draft', function(){
    });

//dom/document event handler

//numeric && masking field only for textfields

    $(".numeric").numeric({ decimal : ".",  negative : false, scale: 6 });  
    
    $('#prof_price').mask("#,##0.00", {reverse: true});
    

//numeric && masking field only for textfields


//select get data attrib value && set value

    var thickness_code = $('#thickness-panel-').find(':selected').data('thk_code');

    var price_config = $('#unit_price-panel-'+srl_num+'[data-p_config]').attr('data-p_config');
    $('#thickness-panel-'+srl_num+' option[data-thk_code=' + ui.item.thickness +']').attr("selected","selected");


    $('#unit_price-panel-'+srl_num).attr('data-p_config','fromdb');


//select get data attrib value && set value


//display/hide modal

    $('#labor_window').modal({
        backdrop: 'static'
    });

    $('#charges_window').modal('hide');


//display/hide modal


//sum by .each

    function calculateSum() {
        var sum = 0;

        $(".charges").each(function () {

            var num = $(this).val().replace(/,/g, "");

            if ($(this).val().length != 0) {
                sum += parseFloat(num);
            }
        });
        $("#total_charges").val($.number(sum.toFixed(2),2));

    }

//sum by .each

//copy & remove


    var copy_remove = function(stage) {

        $('.copy').unbind('click').bind('click', function() {

            var btn = $(this);
            var row = btn.closest('tr');

            var cloned_row = row.clone();
            cloned_row.find("select").each(function(x){
                this.selectedIndex = row.find("select")[x].selectedIndex;
            });

            btn.closest('tbody').append(cloned_row);

            refresh_table_index();

        });

        $('.remove').unbind('click').bind('click', function() {

            $(this).closest('tr').remove();

            refresh_table_index();
    
        });


    }


    var refresh_table_index = function() {

        $('#table_name > tbody > tr').each(function (i) {

            i++;
            var select = $(this).find('select');
            var text = $(this).find('input');
            var button = $(this).find('button');

            $('#ln_no-panel-' + i).attr('value', i);

            text.eq(0).attr('id', 'category-panel-'+ i);
       

            select.eq(0).attr('id', 'color-panel-'+i);

      
            button.eq(0).attr('id', 'remove-panel-'+i);


            controls(i);
        });

        $(".numeric").numeric({ decimal : ".",  negative : false, scale: 6 });

    }

//copy & remove


//sweet alert

        swal({    
            title: "Mark RFE as Done?",  
            text: 'text ',  
            type: "",   showCancelButton: true,confirmButtonColor: "#DD6B55",showLoaderOnConfirm: true,    
            confirmButtonText: "Yes",   closeOnConfirm: false }, 
        
        function() {   
        });


        swal({       
            title: "Successfully Returned.",  
            text: 'text',  
            type: "success", confirmButtonColor: "#DD6B55",showLoaderOnConfirm: false,    
            confirmButtonText: "Ok",   closeOnConfirm: true }, 
        
        function() {
            location.reload();
        });


        swal({  title: "Marked RFE as existing in SQ.",
            text: "Text",
            type: "input",
            confirmButtonText: "Marked",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            animation: "slide-from-top",
            inputPlaceholder: "Type a reason/comments" },

        function(inputValue){ 
            if (inputValue === false) return false;  
            if (jQuery.trim(inputValue).length <= 0 ) {   
                swal.showInputError("Please type a note/comment.");   
                return false  
            }
        });

//sweet alert


//upload file by form-data

    image_file($('#img').prop('files')[0],rfe_no,rand);
    
    // <input type="file" name="img[]" id="img" multiple> 
    

    var image_file = function(img,rfe_no,rand) {

        var form_data = new FormData(); 
        var files = $('#img')[0].files;

        for(var count = 0; count<files.length; count++) {
            var name = files[count].name;
            form_data.append("files[]", files[count]);
        }        
        form_data.append('rfe_no', rfe_no); 
        form_data.append('rand', rand);

        $.ajax({

        data : form_data 
            ,type : "POST"
            , url: "<?php echo base_url('req_esti_controller/upload_img_file'); ?>"
            , dataType : "json" 
            , crossOrigin : false
            , contentType: false
            , processData: false
            , beforeSend : function() {
                $("#save,#submit").prop("disabled", true);
            
            }
            , success : function(result) {

                if(result.status == "success") {

                    $("#save,#submit").removeAttr('disabled');

                }else {
                    console.log(result.status);
                }

            }, failure : function(msg) {
                console.log("Error connecting to server...");
            }, error: function(status) {
                
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


//upload file by form-data