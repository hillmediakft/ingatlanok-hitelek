var Ingatlanok = function () {

    var equalHeights = function () {
        setTimeout(function () {
            $('#equalheight-property-list div.item').equalHeights();
        }, 200);
    };


    /* ********************** Listázási sorrend módosítása ************************* */
    var setOrder = function () {
        $('#sorrend_select').on('change', function () {
            url = $("#sorrend_select option:selected").val();
            window.location.href = location.protocol + "//" + location.host + url;
        });
    };

        /* ********************** Reset filter ************************* */
        var resetFilter = function () {
            $('#reset-filter').on('click', function () {
                window.location.href = location.protocol + "//" + location.host + '/ingatlanok';
            });
        };


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