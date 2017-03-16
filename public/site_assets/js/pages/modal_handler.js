var modalHandler = function () {
    
   /**
    *  Login form adatok küldése
    */
    var send_login_data = function() {
        
        var $data = $("#login_form").serialize();

        $.ajax({
            url: "user/login",
            data: $data,
            type: "POST",
            dataType: "json",
            //beforeSend: function(){},
            //complete: function(){},
            success: function(respond){
                if(respond.status == 'logged_in'){
                    //console.log('bejelentkezve');
                    $('#modal_login').modal('hide');

                    //átirányítás kezelése (alapesetben újratöltjük az oldalt, de ha a regisztráció ellenőrző oldalról irányítunk át akkor a home oldalra kell irányítani)
                    var str = window.location.pathname;
                    var url_part = str.search(/regisztracio\/\d/); //megnézzük, hogy szerepel-e regisztracio/szam az url-ben
                    //ha nincs regisztracio/szam az url-ben
                    if(url_part == -1){
                        window.location.reload();
                    } else {
                        $host = window.location.hostname;
                        window.location.assign('http://' + $host);
                    }
                }
                else if (respond.status == 'error'){
                    $error_messages = '';
                    $.each( respond.message, function( index, value ){
                        $error_messages += value + "<br />"; 
                    });
                    $("#message_login").html('<div class="alert alert-danger">'+$error_messages+'</div>');						
                }
            },
            error: function(result, status, e){
                alert(e);
            } 
        });	
    };
 
	var handle_login_modal = function(){
		
	// amikor megjelenik a modal
		$('#modal_login').on('shown.bs.modal', function () {
			//$('#modal_login').focus()
            
            // login form validásás
            console.log('login validátor indul');

            $('#login_form').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                //ignore: "", // validate all fields including form hidden input
                rules: {
                    user_name: {
                        required: true,
                        minlength: 2
                    },
                    user_password: {
                        required: true
                    }
                },
                // az invalidHandler akkor aktiválódik, ha elküldjük a formot és hiba van
                invalidHandler: function (event, validator) { //display error alert on form submit              
                    var errors = validator.numberOfInvalids();
                    console.log(errors + ' hiba a formban');    
                },
                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group                   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group                   
                },
                success: function (label) {
                    //label.closest('.form-group').removeClass('has-error').addClass("has-success"); // set success class to the control group
                    label.closest('.form-group').removeClass('has-error'); // set success class to the control group
                },
                submitHandler: function (form) {
                    console.log('form küldése!');	
                    send_login_data();
                }
            });           

		});
		
	// amikor eltűnik a modal
		$('#modal_login').on('hidden.bs.modal', function () {
			// form adatok törlése
			document.getElementById("login_form").reset();
			// üzenetek törlése
			$("#message_login").html('');
		});		

		
	// Login form elküldése ha ráklikkelünk a login_submit gombra
		$("#login_submit").on('click', function(){
			$("#login_form").submit();
		});

	// Ha ráklikkel az elfelejett jelszó linkre
		$("#new_pw_button").on('click', function(e){
			e.preventDefault();
			$("#modal_login").modal('hide');
            
            // az elfelejtett jelszó modal megjelenését várakoztatni kell, hogy befejeződjön a login modal eltűnése, mert hibát okoz
            setTimeout(function() {
                handle_forgottenpw_modal();
            }, 500);

		});
	};
	
    
    /*
     * Elfelejtett jelszó for adatok küldése ajaxal
     */
    var send_forgottenpw_data = function(){

        var $data = $("#forgottenpw_form").serialize();
				
        $.ajax({
            url: "user/forgottpw",
            data: $data,
            type: "POST",
            dataType: "json",
            beforeSend: function(){
                $.blockUI({
                    boxed: true,
                    message: '<h3>Feldolgozás...</h3>',
                    baseZ: 9999
                }); 
            },
            complete: function(){
                $.unblockUI();
            },
            success: function(respond){
                if(respond.status == 'success'){
                    $("#forgottenpw_submit").hide();
                    $("#forgottenpw_form").hide();
                    $("#message_forgottenpw").html('<div class="alert alert-success">' + respond.message + '</div>');
                } 
                if(respond.status == 'error') {
                    $("#message_forgottenpw").html('<div class="alert alert-danger">' + respond.message + '</div>');
                }
            },
            error: function(result, status, e){
                alert(e);
            } 
        });         
        
    };
        
    /*
     * Elfelejtett jelszó modal kezelése
     */
    var handle_forgottenpw_modal = function(){
        // megjelenítjük a modalt
        $("#modal_forgottenpw").modal('show');
        
        // amikor megjelenik a modal
		$('#modal_forgottenpw').on('shown.bs.modal', function () {

            $('#forgottenpw_form').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                //ignore: "", // validate all fields including form hidden input
                rules: {
                    user_email: {
                        required: true,
                        email: true
                    }
                },
                // az invalidHandler akkor aktiválódik, ha elküldjük a formot és hiba van
                invalidHandler: function (event, validator) { //display error alert on form submit              
                    var errors = validator.numberOfInvalids();
                },
                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group                   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group                   
                },
                success: function (label) {
                    //label.closest('.form-group').removeClass('has-error').addClass("has-success"); // set success class to the control group
                    label.closest('.form-group').removeClass('has-error'); // set success class to the control group
                },
                submitHandler: function (form) {
                    send_forgottenpw_data();
                }
            });           

		});
        
	    // amikor eltűnik a modal
		$('#modal_forgottenpw').on('hidden.bs.modal', function () {
			// form adatok törlése
			document.getElementById("forgottenpw_form").reset();
			// üzenetek törlése
			$("#message_forgottenpw").html('');
			// form láthatóságának visszaállítása
			$("#forgottenpw_submit").show();
			$("#forgottenpw_form").show();            
		});
        
	    // forgottenpw form elküldése ha ráklikkelünk a login_submit gombra
		$("#forgottenpw_submit").on('click', function(){
			$("#forgottenpw_form").submit();
		});        
        
        
        
    };
    
    
       
    
   /**
    *  Register form adatok küldése
    */
    var send_register_data = function (){
			
        var $data = $("#register_form").serialize();
				
        $.ajax({
            url: "user/register",
            data: $data,
            type: "POST",
            dataType: "json",
            beforeSend: function(){
                $.blockUI({
                    boxed: true,
                    message: '<h3>Feldolgozás...</h3>',
                    baseZ: 9999
                }); 
            },
            complete: function(){
                $.unblockUI();
            },
            success: function(respond){
                if(respond.status == 'success'){
                    
					$success_messages = '';
                    $.each( respond.message, function( index, value ){
                        //console.log(index + ' : ' + value);
                        $success_messages += value + "<br />"; 
                    });
                    
					//$success_messages += '<br />';
                    $("#register_submit").hide();
                    $("#close_button").show();
                    $("#register_form").hide();
                    $("#message_register").html('<div class="alert alert-success">'+$success_messages+'</div>');
                } 
                if(respond.status == 'error') {
                    $error_messages = '';
                    $.each( respond.message, function( index, value ){
                        //console.log(index + ' : ' + value);
                        $error_messages += value + "<br />"; 
                    });
                    $("#message_register").html('<div class="alert alert-danger">'+$error_messages+'</div>');
                }
            },
            error: function(result, status, e){
                alert(e);
            } 
        });        
    };

	
	/**
	 *	A regisztrációs modal megjelenéséhez,
	 *	illetve eltűnéséhez kapcsolódó események
	 */
	var handle_register_modal = function(){

	// amikor megjelenik a modal
		$('#modal_register').on('shown.bs.modal', function () {
			//$('#modal_register').focus()
			
            // register form validálás
            //console.log('register validátor indul');

            $('#register_form').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                //ignore: "", // validate all fields including form hidden input
                rules: {
                    user_name: {
                        required: true,
                        minlength: 3
                    },
                    user_email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                    password_again: {
                        equalTo: "#register_password"
                    }
                },
                // az invalidHandler akkor aktiválódik, ha elküldjük a formot és hiba van
                invalidHandler: function (event, validator) { //display error alert on form submit              
                    var errors = validator.numberOfInvalids();
                    console.log(errors + ' hiba a formban');    
                },
                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group                   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group                   
                },
                success: function (label) {
                    //label.closest('.form-group').removeClass('has-error').addClass("has-success"); // set success class to the control group
                    label.closest('.form-group').removeClass('has-error'); // set success class to the control group
                },
                submitHandler: function (form) {
                    console.log('form küldése!');	
                    // form adatok küldése
					send_register_data();
                }
            });           
			
		});
		
	

	// amikor eltűnik a modal
		$('#modal_register').on('hidden.bs.modal', function () {
			//$('#modal_register').focus()
			// form adatok törlése
			document.getElementById("register_form").reset();
			//checkbox "ürítése"
			$("#user_newsletter").closest("div").removeClass("ez-checked");
			// üzenetek törlése
			$("#message_register").html('');
			// form láthatóságának visszaállítása
			$("#register_submit").show();
			$("#register_form").show();
			
		});

	// Regisztrációs form elküldése ha ráklikkelünk a register_submit gombra
		$("#register_submit").on('click', function(){
			$("#register_form").submit();
		});		
		
	};
 

    //pop up modal megjelenítő
    var initPopUp = function(){
        if (document.cookie.indexOf("pop-up") >= 0) {
            return;
        } else {
            document.cookie = "pop-up=true";
            $('#pop-up-window').modal('show');
        }
    }
	
	return {

		//main method to initiate page
		init: function () {
			handle_login_modal();
			handle_register_modal();
            initPopUp();
		}
 
	};
}();   

jQuery(document).ready(function ($) {
    modalHandler.init();
});