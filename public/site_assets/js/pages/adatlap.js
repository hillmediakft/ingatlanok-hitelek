var Adatlap = function () {

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

    /**
     * Értesítés árváltozásról regisztráció funkciót kezeli
     */
    var arvaltozasReg = function () {

        $('#arvaltozas_ertesites').on('click', function (event) {
            event.preventDefault();

            var gomb = $(this);

            // ha már van disabled osztálya a gombnak
            if ($(gomb).hasClass('disabled')) {
                return false;
            }

            var propertyID = $(gomb).attr('data-id');

            $.ajax({
                url: '/ingatlanok/arvaltozasertesites',
                type: 'post',
                dataType: 'json',
                data: {property_id: propertyID},

                beforeSend: function () {
                    /*
                     App.blockUI({
                     boxed: true,
                     message: 'Feldolgozás...'
                     });
                     */
                },
                complete: function () {
                    /*
                     App.unblockUI();
                     */
                },
                // itt kapjuk meg (és dolgozzuk fel) a feldolgozó php által visszadott adatot 
                success: function (result) {
                    if (result.status == 'success') {
                        // disabled-re állítjuk a gombot
                        $(gomb).addClass('disabled');
                        // üzenet megjelenítése
                        toastr['success'](result.message);
                    }

                    if (result.status == 'error') {
                        // üzenet megjelenítése
                        toastr['error'](result.message);
                    }

                },
                error: function (result, status, e) {
                    console.log(e);
                }
            });

        });

    };

    // kapcsolat űrlap az irodánk oldalon
    var contactAgent = function () {

        $("#contact-form-agent").on('submit', function (event) {
            event.preventDefault();
            var $form = $(this);

            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                dataType: 'json',
                data: $form.serialize(),
                beforeSend: function () {
                    $('#submit-button').addClass('button-loading');
                },
                success: function (result) {
                    //result = JSON.parse(result);
                    $('#submit-button').removeClass('button-loading');
                    document.getElementById("contact-form-agent").reset();
                    toastr[result.status](result.message, result.title)
                },
            });

        });
    }

    var equalHeights = function () {
        var elem = ($('.object-slider.latest-properties'));
        if (elem.length == 0) {
            return false;
        }
        setTimeout(function () {
            $('.object-slider.latest-properties div.item').equalHeights();
        }, 200);
    };

    /**
     * Értesítés árváltozásról regisztráció funkciót kezeli
     */
    var adatlapNyomtatas = function () {

        $("#adatlap_nyomtatas").on('click', function (event) {
            event.preventDefault();
            $("#adatlap_nyomtatas_form").submit();
        });

        /*
         $("#adatlap_nyomtatas_form").on('submit', function (event) {
         event.preventDefault();
         this.submit();
         });
         */
    };

    /**
     * Értesítés árváltozásról regisztráció funkciót kezeli
     */
    var initShare = function () {

        $("#myPopover").popover({
            html: true
        });
    };
	
    /**
     *	Telefonszám mutatása
     */
    var getPhoneNumber = function () {

        var agentId = $('#agent_id').val();
        $("#show_phone_number").click(function () {

            $.ajax({
                type: "POST",
                url: 'getphonenumber',
                data: 'id=' + agentId,
                success: function (data) {
                    $('#show_phone_number').html('<i class="fa fa-phone-square"></i> ' + data);


                }
            });
        });	
	}
		
    /*
     * Google térkép objektumok
     */
    /*
     var googleMapsInit = function () {
     
     // Koordináták        
     var lat = $('#map-banner-canvas').attr('data-lat');
     var lng = $('#map-banner-canvas').attr('data-lng');
     
     //var myLatlng = new google.maps.LatLng(47.498983, 19.058315);
     var myLatlng = new google.maps.LatLng(lat, lng);
     
     var map_canvas = document.getElementById('map-banner-canvas');
     
     var map_options = {
     scrollwheel: false,
     center: myLatlng,
     zoom: 15,
     mapTypeId: google.maps.MapTypeId.ROADMAP,
     mapTypeControl: false,
     zoomControl: true,
     zoomControlOptions: {
     style: google.maps.ZoomControlStyle.LARGE,
     position: google.maps.ControlPosition.LEFT_CENTER
     },
     panControl: true,
     panControlOptions: {
     position: google.maps.ControlPosition.LEFT_CENTER
     },
     scaleControl: false,
     streetViewControl: true
     };
     
     var map = new google.maps.Map(map_canvas, map_options);
     
     var image = {
     url: 'public/site_assets/images/markers/banner-map/1.6.png',
     size: new google.maps.Size(60, 62),
     origin: new google.maps.Point(0, 0)
     };
     
     var marker = new google.maps.Marker({
     position: myLatlng,
     map: map,
     icon: image
     });         
     
     };
     */

    return {

        //main method to initiate page
        init: function () {
            arvaltozasReg();
            contactAgent();
            equalHeights();
            //googleMapsInit();
            adatlapNyomtatas();
            initShare();
			getPhoneNumber();
        },

    };
}();

$(document).ready(function () {
    Adatlap.init();
});