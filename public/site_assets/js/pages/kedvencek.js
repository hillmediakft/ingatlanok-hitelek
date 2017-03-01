var Kedvencek = function () {

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    /* ********************** Kedvencekhez adás ************************* */
    var addToFavourites = function () {
        $('[id*=kedvencekhez]').on('click', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                property_id = $(this).attr('data-id');
                $.ajax({
                    type: "post",
                    url: "kedvencek/add_property_to_cookie",
                    data: "ingatlan_id=" + property_id,
                    beforeSent: function () {
                    },
                    complete: function () {
                    },
                    success: function (result) {
                        $('#kedvencek_' + property_id).addClass('active');
                        kedvencek_szama = $('#kedvencek span.badge').html();
                        kedvencek_szama++;
                        $('#kedvencek span.badge').html(kedvencek_szama);
                        $('#kedvencekhez_' + property_id).addClass('disabled');
                        toastr['success'](result.message);
                    }
                });
            }

        });
    }

    /* ********************** Kedvenc törlése ************************* */
    // olyan elemeknél is működik, amelyeket dinamikusan hoztunk létre 
    var deleteFavourite = function () {
        $('[id*=delete_from_kedvencek]').on('click', function (event) {
            event.preventDefault();
            
            var property_id = $(this).attr('data-id');

            $.ajax({
                type: "post",
                url: "kedvencek/delete_property_from_cookie",
                data: "ingatlan_id=" + property_id,
                beforeSent: function () {
                },
                complete: function () {
                },
                success: function (result) {

                    kedvencek_szama = $('#kedvencek span.badge').html();
                    kedvencek_szama = kedvencek_szama - 1;
                    $('#kedvencek span.badge').html(kedvencek_szama);
                    $('#kedvenc_item_' + property_id).slideUp();
                    toastr['success'](result.message);

                }
            });


        });
    }

    /* ********************** Listázási sorrend módosítása ************************* */
    var getKedvencekNumber = function () {
        var kedvencekCookie = decodeURIComponent(readCookie('kedvencek'));
        kedvencekCookie = kedvencekCookie.substring(1);
        kedvencekCookie = kedvencekCookie.slice(0, -1);
        kedvencekCookie = kedvencekCookie.split(',');
        number = kedvencekCookie.length;
        console.log(kedvencekCookie);
        console.log(number);
        return number;

    }

    var readCookie = function (name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0)
                return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    return {
        //main function to initiate the module
        init: function () {
            addToFavourites();
            deleteFavourite();
        }
    };

}();


jQuery(document).ready(function () {
    Kedvencek.init();
});