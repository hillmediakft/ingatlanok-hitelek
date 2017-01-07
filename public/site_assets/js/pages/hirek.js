var Hirek = function () {

    var equalHeights = function () {
        $('#equalheight div.descr').equalHeights();
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