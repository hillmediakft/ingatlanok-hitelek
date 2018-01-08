var Hirek = function () {

    var equalHeights = function () {
        if($(window).width() > 767) {
			setTimeout(function () {
				$('#equalheight div.descr').equalHeights();
			}, 200);
		}
    }

    return {
        //main function to initiate the module
        init: function () {
            equalHeights();
        }
    };
}();

jQuery(document).ready(function ($) {
    Hirek.init();
});