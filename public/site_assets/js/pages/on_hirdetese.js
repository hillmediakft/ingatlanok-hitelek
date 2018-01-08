var OnHirdetese = function () {

    // kapcsolat űrlap az irodánk oldalon
    var contact = function () {

        $("#contact-form-kapcsolat").on('submit', function (event) {
            event.preventDefault();

            var $form = $(this);

            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                dataType: 'json',
                data: $form.serialize(),
                beforeSend: function() {
                    //$('#submit-button').addClass('disabled');
                    $('#submit-button').addClass('button-loading');
                }, 
                success: function (result) {
                    //$('#submit-button').removeClass('disabled');
                    $('#submit-button').removeClass('button-loading');
                    document.getElementById("contact-form-kapcsolat").reset();
                    toastr[result.status](result.message, result.title)
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
    OnHirdetese.init();
});