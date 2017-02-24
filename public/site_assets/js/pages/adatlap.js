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
     * 
     *
     */
    var arvaltozasReg = function () {
        var propertyID = $('#arvaltozas_ertesites').attr('data-id');

        $('#arvaltozas_ertesites').on('click', function(){

             console.log(propertyID);

            $.ajax({
                url: '/ingatlanok/arvaltozasErtesites',
                type: 'POST',
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

toastr['success'](result.message);

                    }
            
                    if(result.status == 'error'){

toastr['error'](result.message);
   
                    }
            
                },
                error: function(result, status, e){
                        console.log(e);
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
			// call local function
            arvaltozasReg();
			//googleMapsInit();
		},
 

	};
}();

$(document).ready(function() {
	Adatlap.init();
});