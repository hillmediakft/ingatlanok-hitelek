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

        $('#arvaltozas_ertesites').on('click', function(event){
            event.preventDefault();
            
            var gomb = $(this);

            // ha már van disabled osztálya a gombnak
            if ($(gomb).hasClass('disabled')) {
                return false;
            }

            var propertyID = $(gomb).attr('data-id');

            $.ajax({
                url: '/ingatlanok/arvaltozasErtesites',
                type: 'post',
                dataType: 'json',
                data: {property_id: propertyID},
            
                beforeSend: function() {
                    /*
                    App.blockUI({
                        boxed: true,
                        message: 'Feldolgozás...'
                    });
                    */
                },
                complete: function(){
                    /*
                    App.unblockUI();
                    */
                },
                // itt kapjuk meg (és dolgozzuk fel) a feldolgozó php által visszadott adatot 
                success: function(result){
                    if(result.status == 'success'){
                        // disabled-re állítjuk a gombot
                        $(gomb).addClass('disabled');
                        // üzenet megjelenítése
                        toastr['success'](result.message);
                    }
            
                    if(result.status == 'error'){
                        // üzenet megjelenítése
                        toastr['error'](result.message);
                    }
            
                },
                error: function(result, status, e){
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
                beforeSend: function() {
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
			// call local function
            arvaltozasReg();
            contactAgent();
			//googleMapsInit();
		},
 

	};
}();

$(document).ready(function() {
	Adatlap.init();
});