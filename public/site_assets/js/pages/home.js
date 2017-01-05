var Home = function () {

    var locationsInput = function () {

        //kerület és városrész option lista megjelenítése, ha a kiválasztott megye Budapest
        $("#megye_select").change(function () {

            alert('hhh');
            var str = "";
            //option listaelem tartalom
            str = $("select#megye_select option:selected").text();
            // option listaelem value
            option_value = $("select#megye_select option:selected").val();

            // az érték üres lesz, ha a válassz elemet választjuk ki az option listából
            if (option_value !== '') {

                $('#loadingDiv').html('<img src="public/admin_assets/img/loader.gif">');
                $('#loadingDiv').show();

                var county_id = $("#megye_select").val();

                $.ajax({
                    type: "post",
                    url: "admin/property/county_city_list",
                    data: "county_id=" + county_id,
                    beforeSent: function () {
                        $('#loadingDiv').show();
                    },
                    complete: function () {
                        $('#loadingDiv').hide();
                    },
                    success: function (data) {
                        //console.log(data);
                        $("#varos_div > select").html(data);
                    }
                });

            }


        })
    }

    var enableDistrict = function () {

        //kerület és városrész option lista megjelenítése, ha a kiválasztott megye Budapest
        $("#varos").change(function () {
            var str = "";
            //option listaelem tartalom
            str = $("select#varos option:selected").text();
            
            // option listaelem value
            option_value = $("select#varos option:selected").val();
console.log(option_value);
            // az érték üres lesz, ha a válassz elemet választjuk ki az option listából
            if (option_value == '88') {
                $('#district').prop("disabled", false);

            } else {
                $('#district option[value=""]').prop('selected', true);
                $('#district').prop("disabled", true);
                 
            }


        })
    }


    return {
        //main function to initiate the module
        init: function () {
            enableDistrict();
            locationsInput();
            console.log('init');
        }
    };


}();


jQuery(document).ready(function ($) {
    Home.init();
});