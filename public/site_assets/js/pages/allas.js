var Allas = function () {

    // kapcsolat űrlap az irodánk oldalon
    var contact = function () {

        $("#allas-form").on('submit', function (event) {
            event.preventDefault();

            var $form = $(this);
            var data = new FormData($form[0]);

            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                dataType: 'json',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    //$('#submit-button').addClass('disabled');
                    $('#submit-button').addClass('button-loading');
                },
                success: function (result) {
                    //$('#submit-button').removeClass('disabled');
                    $('#submit-button').removeClass('button-loading');
                    document.getElementById("allas-form").reset();
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
    Allas.init();
});