var Adatlap = function () {

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
			//googleMapsInit();
		},
 

	};
}();

$(document).ready(function() {
	//Adatlap.init();
});