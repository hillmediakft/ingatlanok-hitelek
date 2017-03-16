var PopUpWindows = function () {
 

	return {
 
		//main method to initiate page
		init: function () {

			vframework.ckeditorInit({
				content: "config_max1"
			});

			vframework.hideAlert();

		},
	};
}();

$(document).ready(function() {
	PopUpWindows.init();
});