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
    };

    var enableDistrict = function () {

        var option_value = $("select#varos option:selected").val();
        // az érték üres lesz, ha a válassz elemet választjuk ki az option listából
        if (option_value == '88') {
            $('#district').prop("disabled", false);
        }

        //kerület és városrész option lista megjelenítése, ha a kiválasztott megye Budapest
        $("#varos").change(function () {

            //option listaelem tartalom
            var str = $("select#varos option:selected").text();
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

    var equalHeights = function () {
        setTimeout(function () {
            $('.object-slider.latest-properties div.item').equalHeights();
        }, 200);
    };
    var initToastr = function () {


        toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "2000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }


    };

    var kedvencek = function () {
        $('#kedvencek').click(function () {
            lang = $('html').attr('lang');
            if(lang == 'hu') {
                lang = '';
            } else {
                lang = lang+'/';
            }
            $.ajax({
                type: "post",
                url: lang+"ajaxrequest/kedvencek",
                success: function (data) {
                    console.log(data);
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        toastr[data.status](data.message, data.title)
                    }
                }
            });


            // toastr['error']("Nincs bejelentkezve ", "A kedvencek funkció használatához be kell jelentkeznie.")
        })
    };


    return {
        //main function to initiate the module
        init: function () {
            enableDistrict();
            locationsInput();
            equalHeights();
            initToastr();
            kedvencek();
        }
    };


}();


jQuery(document).ready(function ($) {
    Home.init();
});