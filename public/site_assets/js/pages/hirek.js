var Hirek = function () {

    var equalHeights = function () {
        setTimeout(function () {
            $('#equalheight div.descr').equalHeights();
        }, 200);
    }

    return {
        //main function to initiate the module
        init: function () {
            equalHeights();
        }
    };
}();

jQuery(document).ready(function ($) {
    Hirek.init();
});