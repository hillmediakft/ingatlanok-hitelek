var Kereses = function () {

	var resetSearch = function(){
		$("#reset_form").on('click', function(event){
			event.preventDefault();
			//document.getElementById("advanced_filter_form").reset();
		
			var form = $("#advanced_filter_form");

			$(':input', form).each(function() {
				var type = this.type;
				var tag = this.tagName.toLowerCase(); // normalize case
				// it's ok to reset the value attr of text inputs, 
				// password inputs, and textareas
				if (type == 'text' || type == 'password' || tag == 'textarea') {
					this.value = "";
				}
				// checkboxes and radios need to have their checked state cleared 
				// but should *not* have their 'value' changed
				else if (type == 'checkbox' || type == 'radio') {
					this.checked = false;
				}
				// select elements need to have their 'selectedIndex' property set to -1
				// (this works for both single and multiple select elements)
				else if (tag == 'select' && this.name != 'kerulet[]'){
					this.selectedIndex = 0;
					$(this).selectmenu( "refresh" );
				}
				else if (tag == 'select' && this.name == 'kerulet[]'){
					$(this).prop("disabled", true);
					$(this).selectpicker('deselectAll');
					$(this).selectpicker('refresh');
				}
			});

		});
	}

 

	return {
 
		//main method to initiate page
		init: function () {           
			resetSearch();
		}

	};
}();

$(document).ready(function() {
	Kereses.init();
});