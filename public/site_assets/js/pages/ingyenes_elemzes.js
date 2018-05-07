var Ingyenes_elemzes = function () {

    /**
     * Modal megjelenítése
     */
    var showModal = function(){
        $('#show_modal_button').on('click', function(){
            $('#modal_ingy_elemzes').modal('show'); 
        });
    } 

    /**
     * Adatok küldése ajax-al
     */
    var sendData = function(){
        var $form = $("#ingy_elemzes_form");
       
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            dataType: 'json',
            data: $form.serialize(),
            beforeSend: function() {
                $('#ingy_elemzes_submit').attr('disabled', true);
                //$('#ingy_elemzes_submit').addClass('button-loading');
            },
            complete: function(){
            }, 
            success: function (result) {
                $('#ingy_elemzes_submit').attr('disabled', false);
                //$('#ingy_elemzes_submit').removeClass('button-loading');
                document.getElementById("ingy_elemzes_form").reset();
                
                // modal eltűntetése
                $('#modal_ingy_elemzes').modal('hide');

                // toastr üzenet megjelenítése
                $('#modal_ingy_elemzes').on('hidden.bs.modal', function (e) {
                    toastr[result.status](result.message, result.title);
                });

            },
            error: function(result, status, e){
                console.log(e);
            }            
        });
    }  

    var handleModal = function(){
    // amikor megjelenik a modal
        $('#modal_ingy_elemzes').on('shown.bs.modal', function () {
            
            // form validásás
            $('#ingy_elemzes_form').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                //ignore: "", // validate all fields including form hidden input
                rules: {
                    ingatlan_kategoria: {
                        required: true
                    },
                    iranyitoszam: {
                        required: true
                    },
                    alapterulet: {
                        required: true
                    },
                    ingatlan_allapot: {
                        required: true
                    },
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    }
                },
                // az invalidHandler akkor aktiválódik, ha elküldjük a formot és hiba van
                invalidHandler: function (event, validator) { //display error alert on form submit              
                    var errors = validator.numberOfInvalids();
                    console.log(errors + ' hiba a formban');    
                },
                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group                   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group                   
                },
                success: function (label) {
                    //label.closest('.form-group').removeClass('has-error').addClass("has-success"); // set success class to the control group
                    label.closest('.form-group').removeClass('has-error'); // set success class to the control group
                },
                submitHandler: function (form) {
                    sendData();
                }
            });           

        });
        
    // Amikor eltűnik a modal
        $('#modal_ingy_elemzes').on('hidden.bs.modal', function () {
            // form adatok törlése
            document.getElementById("ingy_elemzes_form").reset();
        });     
        
    // Form elküldése ha ráklikkelünk a ingy_elemzes_submit gombra
        $("#ingy_elemzes_submit").on('click', function(){
            $("#ingy_elemzes_form").submit();
        });

    };

    return {
        //main function to initiate the module
        init: function () {
            showModal();
            handleModal();
        }
    };
}();

jQuery(document).ready(function ($) {
    Ingyenes_elemzes.init();
});