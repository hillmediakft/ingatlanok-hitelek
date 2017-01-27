var handleSearch = function () {

    /**
     * Kerület lista kezelése
     */
/*     
    var enableDistrict_SIMA = function () {

        var option_value = $("select#varos option:selected").val();

        if (option_value == '88') {
            $('#district').prop("disabled", false);
        }

        //kerület és városrész option lista megjelenítése, ha a kiválasztott megye Budapest
        $("#varos").change(function () {
            
            //option listaelem tartalom
            //var str = $("select#varos option:selected").text();
            // option listaelem value
            option_value = $("select#varos option:selected").val();
            // az érték üres lesz, ha a válassz elemet választjuk ki az option listából

            if (option_value == '88') {
                $('#district').prop("disabled", false);

            } else {
                $('#district option[value=""]').prop('selected', true);
                $('#district').prop("disabled", true);
            }
        })
    };
*/

    /**
     * Kerület lista kezelése
     */
    var enableDistrict = function () {

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

    };


    /* ********************** Listázási sorrend módosítása ************************* */
    
    //jqueryui selectmenu info: https://api.jqueryui.com/selectmenu/
    var setOrder = function () {
        $( "#sorrend_select" ).selectmenu({
			change: function( event, ui ) {
				url = ui.item.value;
				window.location.href = location.protocol + "//" + location.host + url;    
			}
        });    
    }

/*
    var setOrder_SIMA = function () {
        $('#sorrend_select').on('change', function () {
            url = $("#sorrend_select option:selected").val();
            window.location.href = location.protocol + "//" + location.host + url;
        });
    };
*/

    /* ********************** Reset filter ************************* */
    var resetFilter = function () {
        $('#reset-filter').on('click', function () {
            window.location.href = location.protocol + "//" + location.host + '/ingatlanok';
        });
    };









	var city_select = $("#varos_select");
	var district_select = $("#district_select");
	//var county_select = $("#county_select");
	var category_select = $("#category_select");
	var sorrend_select = $("#sorrend_select");


	/**
	 * 
	 *
	 */
	var search_parts = {
		tipus: '',
		varos: '',
		kerulet: '',
		kategoria: '', 
		min_ar: '', 
		max_ar: '', 
		min_terulet: '',
		order: '',
		order_by: ''
	};
	
	/**
	 *
	 *
	 */
	/*
	var fieldStatus = function(){
		
		this.input = {
			tipus: false,
			varos: false,
			kerulet: false,
			kategoria: false, 
			min_ar: false, 
			max_ar: false, 
			min_terulet: false
		};
		
		this.set_input = function($name, $data){
			this.input[$name] = $data;
		}
		
		this.get_input = function($name){
			return this.input[$name];
		}

	};
	*/

	/**
	 * Megvizsgálja a query stringet és ennek megfelelően beállítja a 
	 * search_parts objektum értékeit
	 */
	var check_search_input = function(){
	
		// query string visszaadása a $search változóba	
		var $search = window.location.search;
		if($search != ''){
		
			var $query_string = window.location.search.substring(1);
			//console.log('QS:' + $query_string);
			
			// a query stringet felbonjuk & jel mentén és berakjuk az elemeket egy tömbbe
			var $qs_parts = $query_string.split('&');
			// átmeneti tömb a ciklusban, ez fogja tártalmazni  akulcsot és az értéket
			var $option;
		
			// berakjuk az értékeket a search_parts objektumba
			$.each( $qs_parts, function( index, value ){
				// a tömb elem kulcs=érték formátumú, ezért az elemeit szintén berakjuk egy tömbbe
				// 0 elem a kulcs, 1. elem az érték
				$option = value.split('=');
				
				if($option[0] == 'tipus'){
					search_parts.tipus = $option[1];
				}
				else if($option[0] == 'varos'){
					search_parts.varos = $option[1];
				}
				else if($option[0] == 'kerulet'){
					search_parts.kerulet = $option[1];
				}
				else if($option[0] == 'kategoria'){
					search_parts.kategoria = $option[1];
				}
				else if($option[0] == 'min_ar'){
					search_parts.min_ar = $option[1];
				}
				else if($option[0] == 'max_ar'){
					search_parts.max_ar = $option[1];
				}
				else if($option[0] == 'min_terulet'){
					search_parts.min_terulet = $option[1];
				}
				else if($option[0] == 'order'){
					search_parts.order = $option[1];
				}
				else if($option[0] == 'order_by'){
					search_parts.order_by = $option[1];
				}
			});

			console.log(search_parts);
			
		}

	};


    return {
        //main function to initiate the module
        init: function () {
        	enableDistrict();
            setOrder();

			//check_search_input();
        }
    };
	
}();

jQuery(document).ready(function ($) {
    handleSearch.init();


	$('#example').selectpicker();


});