var handleSearch = function () {

    /**
     * Kerület lista kezelése
     */
    var enableDistrict_Selectpicker = function () {

    	var option_value = $("select#varos_select option:selected").val();
    // mobil
    	var option_value_mobile = $("select#varos_select_mobile option:selected").val();

        if (option_value == '88') {
            $('#district_select').prop("disabled", false);
            $('#district_select').selectpicker('refresh');
        }
	// mobil
        if (option_value == '88') {
            $('#district_select_mobile').prop("disabled", false);
            $('#district_select_mobile').selectpicker('refresh');
        }

        //kerület és városrész option lista megjelenítése, ha a kiválasztott város Budapest
        $( "#varos_select" ).selectmenu({
			change: function( event, ui ) {
	            //option listaelem tartalom
		            //var str = ui.item.label;
	            // option listaelem value
	            option_value = ui.item.value;
	            if (option_value == '88') {
					$('#district_select').prop("disabled", false);
					$('#district_select').selectpicker('deselectAll');
					$('#district_select').selectpicker('refresh');
	            } else {
	                $('#district_select').prop("disabled", true);
					$('#district_select').selectpicker('deselectAll');
	                $('#district_select').selectpicker('refresh');
	            }

			}

        }); 
	// mobil
        $( "#varos_select_mobile" ).selectmenu({
			change: function( event, ui ) {
	            //option listaelem tartalom
		            //var str = ui.item.label;
	            // option listaelem value
	            option_value = ui.item.value;
	            if (option_value == '88') {
					$('#district_select_mobile').prop("disabled", false);
					$('#district_select_mobile').selectpicker('deselectAll');
					$('#district_select_mobile').selectpicker('refresh');
	            } else {
	                $('#district_select_mobile').prop("disabled", true);
					$('#district_select_mobile').selectpicker('deselectAll');
	                $('#district_select_mobile').selectpicker('refresh');
	            }

			}

        });  

    };

    /**
     * Kerület lista kezelése
     */
/*     
    var enableDistrict_SelectMenu = function () {

        var option_value = $("select#varos_select option:selected").val();

        // ha a város budapest
        if (option_value == '88') {
        	// elérhetővé tesszük a kerület listát
			$( "#district_select" ).selectmenu( "option", "disabled", false );
        }

        //kerület és városrész option lista megjelenítése, ha a kiválasztott város Budapest
        $( "#varos_select" ).selectmenu({
			change: function( event, ui ) {
	            //option listaelem tartalom
		            //var str = ui.item.label;
	            // option listaelem value
	            option_value = ui.item.value;

	            if (option_value == '88') {
	                $( "#district_select" ).selectmenu( "option", "disabled", false );

	            } else {
					// selected-re állítjuk a --mindegy-- elemet
					$('#district_select option[value=""]').prop('selected', true);
					// frissítjük a kerület selectmenüt
					$( "#district_select" ).selectmenu( "refresh" );
	                // disabled-re állítjuk a kerületlistát
	                $( "#district_select" ).selectmenu( "option", "disabled", true );
	            }

			}

        });  

    }
*/


    /**
     *	A keresőnél az ár mértékét állítja: E FT vagy M FT
     */
    var arMertek = function(){

		var lang = $('html').prop('lang'); 	
    	var ezer; 

    	if (lang == 'hu') {
    		ezer = 'E';
    	}
    	else if (lang == 'en') {
    		ezer = 'k';
    	}

    	var type_value = $("select#tipus_select option:selected").val();
    // mobil
    	var type_value_mobile = $("select#tipus_select_mobile option:selected").val();

		if (type_value == 2) {
			$('#ar_mertek').text(ezer + ' Ft');
		}
	// mobil
		if (type_value_mobile == 2) {
			$('#ar_mertek_mobile').text(ezer + ' Ft');
		}

        $( "#tipus_select" ).selectmenu({
			change: function( event, ui ) {
				if (ui.item.value == 1) {
                    $('#ar_mertek').text('M Ft');
                }
                else if (ui.item.value == 2) {
                    $('#ar_mertek').text(ezer + ' Ft');
                }
                else {
					$('#ar_mertek').text('M Ft');
                }
			}
        });
    // mobil
        $( "#tipus_select_mobile" ).selectmenu({
			change: function( event, ui ) {
				if (ui.item.value == 1) {
					$('#ar_mertek_mobile').text('M Ft');
				}
				else if (ui.item.value == 2) {
					$('#ar_mertek_mobile').text(ezer + ' Ft');
				}
                else {
                    $('#ar_mertek_mobile').text('M Ft');
                }
			}
        }); 

    }

    /**
     * Listázási sorrend módosítása (selectmenu bootstrap plugin-os megoldás)
     *
     * jqueryui selectmenu dokumentáció: https://api.jqueryui.com/selectmenu/
     */
    var setOrder = function () {
        $( "#sorrend_select" ).selectmenu({
			change: function( event, ui ) {
				url = ui.item.value;
				window.location.href = location.protocol + "//" + location.host + url;    
			}
        });    
    }

    /**
     * Select menu 
     *
     */
    var select_menu = function() {
    	// ha van selectpicker objektum
        if (document.getElementById("district_select_div") != null) {

			var lang = $('html').prop('lang'); 	
        	var countSelectedText; 

        	if (lang == 'hu') {
        		countSelectedText = 'elem kiválasztva';
        	}
        	else if (lang == 'en') {
        		countSelectedText = 'items selected';
        	}

    		$('#district_select').selectpicker({
    			//size: 4,
    			width: '100%',
    			countSelectedText: '{0} ' + countSelectedText

    		});

    		// mobil
    		$('#district_select_mobile').selectpicker({
    			//size: 4,
    			width: '100%',
    			countSelectedText: '{0} ' + countSelectedText

    		});
    	
        } else {
            return false;
        }   	
    };




    return {
        //main function to initiate the module
        init: function () {
            select_menu();
        	enableDistrict_Selectpicker();
        	//enableDistrict_SelectMenu();
            setOrder();
        	arMertek();
        }
    };
	
}();

jQuery(document).ready(function ($) {
    handleSearch.init();
});