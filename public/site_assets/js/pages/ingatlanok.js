var Ingatlanok = function () {

    var equalHeights = function () {
        setTimeout(function () {
            $('#equalheight-property-list div.item').equalHeights();
        }, 200);
    };

    /**
     * Kerület lista kezelése
     */
    var enableDistrict = function () {

        var option_value = $("select#varos option:selected").val();

        if (option_value == '88') {
            $('#district').prop("disabled", false);
        }

        //kerület és városrész option lista megjelenítése, ha a kiválasztott megye Budapest
        $("#varos").change(function () {
            
            //option listaelem tartalom
            //var str = $("select#varos option:selected").text();
            // option listaelem value
            option_value = $("select#varos option:selected").val();
            // az érték üres lesz, ha a válassz elemet választjuk ki az option listából

            if (option_value == '88') {
                $('#district').prop("disabled", false);

            } else {
                $('#district option[value=""]').prop('selected', true);
                $('#district').prop("disabled", true);
            }
        })
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
            enableDistrict();
            equalHeights();
            setOrder();
        }
    };
}();

jQuery(document).ready(function ($) {
    Ingatlanok.init();
});