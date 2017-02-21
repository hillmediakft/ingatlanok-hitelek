var Kedvencek = function () {

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
                        $('#loadingDiv').show();
                    },
                    complete: function () {
                        $('#loadingDiv').hide();
                    },
                    success: function (data) {
                        console.log('active');
                        //        $('#favourite-property-widget .properties__list').append(data);
                        $('#kedvencek_' + property_id).addClass('active');
                        $('#kedvencekhez_' + property_id).addClass('disabled');
                        //         $('#empty-favourites-list').remove();
                        //         $('#kedvencek_szama').html(getKedvencekNumber());
                        //        app.notifier.showSuccess('Az ingatlant hozzáadta a kedvencekhez!');
                        // $('#hozzaadas_modal').modal('show');
                    }
                });
            }

        });
    }

    /* ********************** Kedvenc törlése ************************* */
    // olyan elemeknél is működik, amelyeket dinamikusan hoztunk létre 
    var deleteFavourite = function () {
        $('#favourite-property-widget').on('click', '[id*=delete_kedvenc]', function () {
            property_id = $(this).attr('data-id');

            $.ajax({
                type: "post",
                url: "ingatlanok/delete_property_from_cookie",
                data: "ingatlan_id=" + property_id,
                beforeSent: function () {
                    $('#loadingDiv').show();
                },
                complete: function () {
                    $('#loadingDiv').hide();
                },
                success: function () {

                    $('#favourite_property_' + property_id).remove();
                    $('#kedvencek_' + property_id).removeClass('active');
                    kedvencekSzama = $("#favourite-property-widget > .properties__list > article").length;
                    if (kedvencekSzama == 0) {
                        $('#favourite-property-widget .properties__list').append('<span id="empty-favourites-list"><i class="fa fa-exclamation-triangle"></i> A kedvencek listája üres!</span>');
                    }
                    $('#kedvencek_szama').html(kedvencekSzama);
                    app.notifier.showSuccess('Az ingatlant törölte a kedvencek közül!');
                    // $('#torles_modal').modal('show');
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


