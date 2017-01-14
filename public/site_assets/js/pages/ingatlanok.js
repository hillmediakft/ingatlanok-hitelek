var Ingatlanok = function () {

    var equalHeights = function () {
        setTimeout(function () {
            $('#equalheight-property-list div.item').equalHeights();
        }, 200);
    };

    /* ********************** Listázási sorrend módosítása ************************* */
    /*
    var setOrder = function () {
        $('#sorrend_div').on('change', '#ui-id-1', function () {
            url = $("#ui-id-1 option:selected").val();
            //window.location.href = location.protocol + "//" + location.host + url;

            console.log(url);
        });
    };
    */


    return {
        //main function to initiate the module
        init: function () {
            equalHeights();
            setOrder();
        }
    };
}();

jQuery(document).ready(function ($) {
    Ingatlanok.init();
});