var Profile = function () {
 
 	/**
 	 * Követett ingatlan törlése az adatbázisból
 	 */
    var deleteFollowed = function () {
        $('[id*=delete_followed]').on('click', function (event) {
            event.preventDefault();
            var property_id = $(this).attr('data-id');

            $.ajax({
                type: "post",
                url: "profile/deleteFollowed",
                dataType: 'json',
                data: {ingatlan_id: property_id},
                beforeSent: function () {
                },
                complete: function () {
                },
                success: function (result) {
                	if (result.status == 'success') {
                    	$('#followed_item_' + property_id).slideUp();
                	} else {
                		console.log(result.message);
                	}
                }
            });

        });
    }    

	return {
 
		//main method to initiate page
		init: function () {           
			// call local function
			deleteFollowed();
		}

	};
}();

$(document).ready(function() {
	Profile.init();
});