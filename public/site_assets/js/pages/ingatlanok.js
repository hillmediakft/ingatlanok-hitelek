var Ingatlanok = function () {

    var equalHeights = function () {
        setTimeout(function () {
            $('#equalheight-property-list div.item').equalHeights();
        }, 200);
    };

    return {
        //main function to initiate the module
        init: function () {
            equalHeights();
        }
    };
}();

jQuery(document).ready(function ($) {
    Ingatlanok.init();
});