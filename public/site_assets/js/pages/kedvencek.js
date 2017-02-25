var Kedvencek = function () {



    return {
        //main function to initiate the module
        init: function () {
            equalHeights();
        }
    };
}();

jQuery(document).ready(function ($) {
    Kedvencek.init();
});