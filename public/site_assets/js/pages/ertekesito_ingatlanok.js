var Ertekesito_ingatlanok = function () {

    var equalHeights = function () {
        console.log('asf');
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
    Ertekesito_ingatlanok.init();
});