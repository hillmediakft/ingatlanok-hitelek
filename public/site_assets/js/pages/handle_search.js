var handleSearch = function () {

	/**
	 * Ár beállító slidert kezeli
	 * 
	 */
	function initRangePrice() {
		// elemek, amik változnak azingatlan típúsának megfelelően (eladó/kiadó)
		var $min;
		var $max;
		var $step;
		var $range_min;
		var $range_max;

		/**
		 * Beállítani a megfelelő értékeket az ingatlan típusának megfelelően
		 * Ha az ingatlan típusát megváltoztatjuk (eladó/kiadó), akkor visszaállítjuk az értékeket a defaultra
		 *
		 * @param type ingatlan típusa (1 vagy 2)
		 * @param is_change true vagy false
		 */
		function setTypeData(type, is_change) {
			// eladó
			if (type == 1) {
				$min = 0;
				$max = 100000000;
				$step = 500000;
				var $range_min_default = 0;
				var $range_max_default = 30000000;
				// ha az ingatlan típus változtatása miatt hívtuk meg a metódust
				if (is_change) {
					$range_min = $range_min_default;
					$range_max = $range_max_default;
				} else {
					// keresés szerinti, vagy default érték
					$range_min = (search_parts.min_ar != '') ? search_parts.min_ar : $range_min_default;
					$range_max = (search_parts.max_ar != '') ? search_parts.max_ar : $range_max_default;
				}

			}
			// kiadó
			else {
				$min = 0;
				$max = 500000;
				$step = 10000;
				var $range_min_default = 0;
				var $range_max_default = 150000;
				// ha az ingatlan típus változtatása miatt hívtuk meg a metódust
				if (is_change) {
					$range_min = $range_min_default;
					$range_max = $range_max_default;
				} else {
					// keresés szerinti, vagy default érték
					$range_min = (search_parts.min_ar != '') ? search_parts.min_ar : $range_min_default;
					$range_max = (search_parts.max_ar != '') ? search_parts.max_ar : $range_max_default;
				}
		
			}
		}

		// az ingatlan típusa (eladó/kiadó)
		var tipus = $('#tipus_select').val();
		// beállítjuk az adatokat, a második paraméter false, mert nem volt típus változtatás 
		setTypeData(tipus, false);
		// érvényesítjük a HTML-elemekre
		runRange();


        $( "#tipus_select" ).selectmenu({
			change: function( event, ui ) {
				// beállítjuk az értékeket az ingatlan típusától függően, második paramétert true-ra kell állítani!
				setTypeData(ui.item.value, true);
				// érvényesítjük a HTML-elemekre
				runRange();
			}
        }); 


/* sima bootstrap-es
		// ha változik az ingatlan típusa (eladó/kiadó)	
		$('#tipus_select').change(function(){
			console.log('ggggg');
			// beállítjuk az értékeket az ingatlan típusától függően
			setTypeData($(this).val());
			// érvényesítjük a HTML-elemekre
			runRange();

		});
*/			

		function addCommas(nStr) {
			var x, x1,x2;
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}

		// módosítja a html-ben lévő értékeket, input mező értékeket stb.
		function runRange(){

			$("#ar_slider").slider({
				min: $min,
				max: $max,
				step: $step,
				values: [$range_min, $range_max],
				range: true,
				stop: function(event, ui) {
					$("input#min_ar").val(addCommas(ui.values[0].toString()));
					$("input#max_ar").val(addCommas(ui.values[1]));
				},
				slide: function(event, ui){
					$("input#min_ar").val(addCommas(ui.values[0].toString()));
					$("input#max_ar").val(addCommas(ui.values[1]));
				}
			});

			$('.range-wrap').each(function(){
				$("input#min_ar").val(addCommas($("#ar_slider").slider("values", 0)));
				$("input#max_ar").val(addCommas($("#ar_slider").slider("values", 1)));
				$('#ar_slider_wrapper .min-value').text($('#ar_slider').slider('option', 'min') + ' Ft');
				$('#ar_slider_wrapper .max-value').text( addCommas( $('#ar_slider').slider('option', 'max') + ' Ft' ) );
				
				$("input#min_ar").change(function(){
					var value1=$("input#min_ar").val().replace(/\D/g,'');
					var value2=$("input#max_ar").val().replace(/\D/g,'');

					if(parseInt(value1, 10) > parseInt(value2, 10)){
						value1 = value2;
						$("input#min_ar").val(value1);
					}
					$("#ar_slider").slider("values",0,value1);	
				});

				
				$("input#max_ar").change(function(){
					var value1=$("input#min_ar").val().replace(/\D/g,'');
					var value2=$("input#max_ar").val().replace(/\D/g,'');
					
					if (value2 > $max) { value2 = $max; jQuery("input#max_ar").val($max)}

					if(parseInt(value1, 10) > parseInt(value2, 10)){
						value2 = value1;
						$("input#max_ar").val(value2);
					}
					$("#ar_slider").slider("values",1,value2);
				});
			});
		} // vege

	}

	/**
	 *	Alapterület beállító slidert kezeli
	 * 
	 */
	function initRangeArea() {
		// a csúszka alapértékei
		var $range_min = 0;
		var $range_max = 150;

			// ha van a query stringben keresés alapterületre, akkor ennek megfelelően állítjuk be a range_min és range_max értékét 
			if (search_parts.min_alapterulet != '') {
				$range_min = search_parts.min_alapterulet;
			}
			if (search_parts.max_alapterulet != '') {
				$range_max = search_parts.max_alapterulet;
			}

		function addCommas(nStr) {
			var x, x1,x2;
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}


		$("#terulet_slider").slider({
			min: 0,
			max: 1000,
			step: 5,
			values: [$range_min, $range_max],
			range: true,
			stop: function(event, ui) {
				$("input#min_terulet").val(addCommas(ui.values[0].toString()));
				$("input#max_terulet").val(addCommas(ui.values[1]));
			},
			slide: function(event, ui){
				$("input#min_terulet").val(addCommas(ui.values[0].toString()));
				$("input#max_terulet").val(addCommas(ui.values[1]));
			}
		});
		$('.range-wrap').each(function(){
			$("input#min_terulet").val(addCommas($("#terulet_slider").slider("values", 0)));
			$("input#max_terulet").val(addCommas($("#terulet_slider").slider("values", 1)));
			$('#terulet_slider_wrapper .min-value').text($('#terulet_slider').slider('option', 'min') + " m2");
			$('#terulet_slider_wrapper .max-value').text($('#terulet_slider').slider('option', 'max') + " m2");
			

			$("input#min_terulet").change(function(){
				var value1=$("input#min_terulet").val().replace(/\D/g,'');
				var value2=$("input#max_terulet").val().replace(/\D/g,'');

				if(parseInt(value1, 10) > parseInt(value2, 10)){
					value1 = value2;
					$("input#min_terulet").val(value1);
				}
				$("#terulet_slider").slider("values",0,value1);	
			});

			
			$("input#max_terulet").change(function(){
				var value1=$("input#min_terulet").val().replace(/\D/g,'');
				var value2=$("input#max_terulet").val().replace(/\D/g,'');
				
				if (value2 > 500) { value2 = 500; jQuery("input#max_terulet").val(500)}

				if(parseInt(value1, 10) > parseInt(value2, 10)){
					value2 = value1;
					$("input#max_terulet").val(value2);
				}
				$("#terulet_slider").slider("values",1,value2);
			});
		});
	}


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

/*
    var setOrder_SIMA = function () {
        $('#sorrend_select').on('change', function () {
            url = $("#sorrend_select option:selected").val();
            window.location.href = location.protocol + "//" + location.host + url;
        });
    };
*/

    /**
     * Reset filter
     */
    var resetFilter = function () {
        $('#reset-filter').on('click', function () {
            window.location.href = location.protocol + "//" + location.host + '/ingatlanok';
        });
    }

    /**
     * Select menu 
     *
     */
    var select_menu = function() {
    	// ha van selectpicker objektum
        if (document.getElementById("example") != null) {
	    
    		$('#example').selectpicker();
    	
        } else {
            return false;
        }   	
    };






/*
	var city_select = $("#varos_select");
	var district_select = $("#district_select");
	//var county_select = $("#county_select");
	var category_select = $("#category_select");
	var sorrend_select = $("#sorrend_select");
*/

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
		min_alapterulet: '',
		max_alapterulet: '',
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
			min_alapterulet: false,
			max_alapterulet: false,
			order: false,
			order_by: false
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
	var checkSearchInput = function(){
		// query string visszaadása a $search változóba	
		var $search = window.location.search;
		if($search != ''){

			// kérdőjel eltávolítása a query string elejéről és dekódolás
			var $query_string = decodeURIComponent(window.location.search.substring(1));
			//console.log('QS:' + $query_string);
			
			// a query stringet felbonjuk & jel mentén és berakjuk az elemeket egy tömbbe
			var $qs_parts = $query_string.split('&');
			// átmeneti tömb a ciklusban, ez fogja tártalmazni a kulcsot és az értéket
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
					// eltávolítjuk a stringből a nem szám karaktereket, és számmá alakítjuk
					search_parts.min_ar = Number( $option[1].replace(/\D/g,'') );
				}
				else if($option[0] == 'max_ar'){
					// eltávolítjuk a stringből a nem szám karaktereket, és számmá alakítjuk
					search_parts.max_ar = Number( $option[1].replace(/\D/g,'') );
				}
				else if($option[0] == 'min_alapterulet'){
					// eltávolítjuk a stringből a nem szám karaktereket, és számmá alakítjuk
					search_parts.min_alapterulet = Number( $option[1].replace(/\D/g,'') );
				}
				else if($option[0] == 'max_alapterulet'){
					// eltávolítjuk a stringből a nem szám karaktereket, és számmá alakítjuk
					search_parts.max_alapterulet = Number( $option[1].replace(/\D/g,'') );
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

	/**
	 *	Sorrend select menü 
	 */
/*	 
	var setOrderSelected = function() {
		// order option
		var selected;

		// elemek értékének beállítása a query string alapján
		//check_search_input();

		// sorrend opciók elemei
		var order_options = $("#sorrend_select option");

		if (search_parts.order != "" && search_parts.order_by != "") {
			
			if (search_parts.order == "desc" && search_parts.order_by == "datum") {
				selected = order_options[0];
				$(order_options[0]).attr('selected', true);
			}
			else if (search_parts.order == "asc" && search_parts.order_by == "datum") {
				selected = order_options[1];
				$(order_options[1]).attr('selected', true);
			}
			else if (search_parts.order == "desc" && search_parts.order_by == "ar") {
				selected = order_options[2];
				$(order_options[2]).attr('selected', true);
			}
			else if (search_parts.order == "asc" && search_parts.order_by == "ar") {
				selected = order_options[3];
				$(order_options[3]).attr('selected', true);
			}

			// frissítjük a sorrend selectmenüt
			$( "#sorrend_select" ).selectmenu( "refresh" );
			console.log($("#sorrend_select option:selected"));
		}


		// selected-re állítjuk a --mindegy-- elemet
		//$('#sorrend_select option[value=""]').prop('selected', true);
		// frissítjük a kerület selectmenüt
		//$( "#district_select" ).selectmenu( "refresh" );		

	};
*/


    return {
        //main function to initiate the module
        init: function () {
			checkSearchInput();
        	
        	//setOrderSelected();
        	
        	enableDistrict();
            setOrder();
            select_menu();
        	initRangePrice();
        	initRangeArea();

        }
    };
	
}();

jQuery(document).ready(function ($) {
    handleSearch.init();
});