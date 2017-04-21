var PropertyDetails = function () {

	var propertyPictures = function () {
        $('.fancybox').fancybox();						 		
	}

    /**
     * Adatalap nyomtatás
     */
    var adatlapNyomtatas = function () {

        $("#generate_pdf").on('click', function (event) {
            event.preventDefault();
            $("#adatlap_nyomtatas_form").submit();
        });

    };


    return {
        //main function to initiate the module
        init: function () {
            propertyPictures();
            adatlapNyomtatas();
        }
    };

}();

jQuery(document).ready(function() {    
	PropertyDetails.init();	
});