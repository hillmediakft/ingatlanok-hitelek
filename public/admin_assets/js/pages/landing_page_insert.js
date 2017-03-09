var Landing_page_insert = function () {

	var insertPageConfirm = function () {
		$('#page_insert_form').submit(function(e){
            e.preventDefault();
			
			var currentForm = this;
			
			bootbox.setDefaults({
				locale: "hu", 
			});
			bootbox.confirm("Biztosan el akarja menteni?", function(result) {
				if (result) {

					App.blockUI({
			            boxed: true,
			            message: 'Feldolgozás...'
			        });

					setTimeout(function(){
						currentForm.submit();
					}, 300); 	
				}
            }); 
        });	 		
	};

    return {

        //main function to initiate the module
        init: function () {
			insertPageConfirm();

			vframework.hideAlert();
			
			vframework.ckeditorInit({
				page_body_hu: "config_max1",
				page_body_en: "config_max1"
			});
			
        }

    };

}();

$(document).ready(function() {    
	console.log('fasfasf');
	Landing_page_insert.init();
});