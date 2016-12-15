var PropertyDetails = function () {

	var propertyPictures = function () {
        $('.fancybox').fancybox();						 		
	}

    return {
        //main function to initiate the module
        init: function () {
            propertyPictures();
        }
    };

}();

jQuery(document).ready(function() {    
	PropertyDetails.init();	
});