var Kapcsolat = function () {

    // kapcsolat űrlap az irodánk oldalon
    var contact = function () {

        $("#contact-form-kapcsolat").on('submit', function (event) {
            event.preventDefault();
            var $form = $(this);
            // $('#panel_ajax_message').empty();
            // $('#panel_ajax_message').hide();

            $('#submit-button').addClass('button-loading');
            //     $('#submit_contact_office').attr('disabled', 'disabled');
            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                dataType: 'json',
                data: $form.serialize(),
                
                success: function (result) {
                    result = JSON.parse(result);
                    //    $('#panel_ajax_message').append(result);
                    //    $('#panel_ajax_message').slideDown('slow');
                    $('#submit-button').removeAttr('disabled');
                    $('#submit-button').removeClass('button-loading');
                    //$('#panel_ajax_message').delay(7500).slideUp(700);
                    toastr[result.status](result.message, result.title)

                    $form.reset();
/*
                    $('#contact-form-kapcsolat input[name="name"]').val('');
                    $('#contact-form-kapcsolat input[name="email"]').val('');
                    $('#contact-form-kapcsolat input[name="phone"]').val('');
                    $('#contact-form-kapcsolat textarea[name="message"]').val('');
*/                    
                }
            });

        });
    }




    return {
        //main function to initiate the module
        init: function () {
            contact();
        }
    };
}();

jQuery(document).ready(function ($) {
    Kapcsolat.init();
});