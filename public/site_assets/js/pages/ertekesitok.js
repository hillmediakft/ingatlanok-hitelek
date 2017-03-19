var Ertekesitok = function () {

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

    var equalHeightsAgents = function () {
        setTimeout(function () {
            $('#agents-equalheights div.agent-item').equalHeights();
        }, 200);
    };

    return {
        //main function to initiate the module
        init: function () {
            equalHeightsAgents();
        }
    };
}();

jQuery(document).ready(function ($) {
    Ertekesitok.init();
});