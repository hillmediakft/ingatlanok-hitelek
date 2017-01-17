var Kapcsolat = function () {

    var contact = function () {

        $("#feedback-form form").on('submit', function (event) {
            var $form = $(this);
            // $('#panel_ajax_message').empty();
            // $('#panel_ajax_message').hide();


            $('#submit_button').after('<img src="public/site_assets/img/ajax-loader.gif" class="loader" />');
            $('#submit_contact').attr('disabled', 'disabled');
            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize(),
                success: function (msg) {
                    msg = JSON.parse(msg);
                    //    $('#panel_ajax_message').append(msg);
                    //    $('#panel_ajax_message').slideDown('slow');
                    $('#feedback-form img.loader').fadeOut('slow', function () {
                        $(this).remove()
                    });
                    $('#submit_contact').removeAttr('disabled');
                    //$('#panel_ajax_message').delay(7500).slideUp(700);
                    if (msg.success) {
                        app.notifier.showSuccess(msg.success);
                    }
                    if (msg.error) {
                        app.notifier.showError(msg.error);
                    }

                    $('#panel_name').val('');
                    $('#panel_email').val('');
                    $('#panel_phone').val('');
                    $('#panel_message').val('');
                }
            });
            event.preventDefault();
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