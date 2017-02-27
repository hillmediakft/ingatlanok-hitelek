var Ertekesito_ingatlanok = function () {

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    var equalHeights = function () {
        console.log('asf');
        setTimeout(function () {
            $('#equalheight-property-list div.item').equalHeights();
        }, 200);
    };

    // kapcsolat űrlap az irodánk oldalon
    var contactAgent = function () {

        $("#contact-form-agent").on('submit', function (event) {
            event.preventDefault();
            var $form = $(this);

            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                dataType: 'json',
                data: $form.serialize(),
                beforeSend: function() {
                    $('#submit-button').addClass('button-loading');
                },                
                success: function (result) {
                    //result = JSON.parse(result);
                    $('#submit-button').removeClass('button-loading');
                    document.getElementById("contact-form-agent").reset();
                    toastr[result.status](result.message, result.title)
                },
            });

        });
    }


    return {
        //main function to initiate the module
        init: function () {
            equalHeights();
            contactAgent();
        }
    };
}();

jQuery(document).ready(function ($) {
    Ertekesito_ingatlanok.init();
});