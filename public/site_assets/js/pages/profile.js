var Profile = function () {
 
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

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

    /**
     * Felhasználó jelszavának módosítása
     */
    var changePassword = function() {
/*
        $("#new-password-form").on('submit', function (event) {
            event.preventDefault();            
        });        
*/
        var $form = $("#new-password-form");

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            dataType: 'json',
            data: $form.serialize(),
            beforeSent: function () {
            },
            complete: function () {
            },
            success: function (result) {
                if (result.status == 'success') {
                    toastr['success'](result.message);
                } else {
                    toastr['error'](result.message);
                    //console.log(result.message);
                }
            }
        });
    }

    /**
     * Felhasználó adatainak módosítása
     */
    var changeNameOrEmail = function() {
/*
        $("#new-userdata-form").on('submit', function (event) {
            event.preventDefault();            
        }); 
*/
        var $form = $("#new-userdata-form");

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            dataType: 'json',
            data: $form.serialize(),
            beforeSent: function () {
            },
            complete: function () {
            },
            success: function (result) {
                if (result.status == 'success') {
                    toastr['success'](result.message);
                    $('#logged_in_user_name').html(result.new_name);
                } else {
                    toastr['error'](result.message);
                    //console.log(result.message);
                }
            }
        });
    }


    /**
     *  Új jelszó form validátor
     */
    var handleValidation_password = function () {

        var password_form = $('#new-password-form');

        password_form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: ":disabled", // validate all fields including form hidden input
            rules: {
                password_new: {
                    required: true,
                    minlength: 4
                },                
                password_new_again: {
                    required: true,
                    equalTo: "#password_new"
                    
                },
                password_old: {
                    required: true
                }
            },

            // hiba elem helye, a helyes megjelenés miatt
            errorPlacement: function (error, element) { // render error placement for each input type
                
                error.insertAfter(element); // for other inputs, just perform default behavior
/*
                if (element.parent(".input-group").size() > 0) {
                    error.insertAfter(element.parent(".input-group"));
                } else if (element.attr("data-error-container")) { 
                    error.appendTo(element.attr("data-error-container"));
                } else if (element.parents('.radio-list').size() > 0) { 
                    error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                } else if (element.parents('.radio-inline').size() > 0) { 
                    error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                } else if (element.parents('.checkbox-list').size() > 0) {
                    error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                } else if (element.parents('.checkbox-inline').size() > 0) { 
                    error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
*/
            },

            // az invalidHandler akkor aktiválódik, ha elküldjük a formot és hiba van
            invalidHandler: function (event, validator) { //display error alert on form submit              
                var errors = validator.numberOfInvalids();
                toastr['error'](errors + ' mezőt nem megfelelően töltött ki!');
            },
            highlight: function (element) { // hightlight error inputs
                //console.log(element);
                $(element).closest('.form-group').addClass('has-error');
                $(element).addClass('has-error');                   
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                $(element).removeClass('has-error');                   
            },
            success: function (label) {
                //console.log(label);
                //label.closest('.form-group').removeClass('has-error').addClass("has-success"); // set success class to the control group
                label.closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function (form) {
                //adatok elküldése "normál" küldéssel
                // password_form.submit();

                changePassword();
                console.log('password_form elkuld');
            }
        });
    };


    /**
     *  Új jelszó form validátor
     */
    var handleValidation_userdata = function () {

        var userdata_form = $('#new-userdata-form');

        userdata_form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: ":disabled", // validate all fields including form hidden input
            rules: {
                name: {
                    minlength: 2
                },                
                email: {
                    email: true
                }
            },

            // hiba elem helye, a helyes megjelenés miatt
            errorPlacement: function (error, element) { // render error placement for each input type
                
                error.insertAfter(element); // for other inputs, just perform default behavior
/*
                if (element.parent(".input-group").size() > 0) {
                    error.insertAfter(element.parent(".input-group"));
                } else if (element.attr("data-error-container")) { 
                    error.appendTo(element.attr("data-error-container"));
                } else if (element.parents('.radio-list').size() > 0) { 
                    error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                } else if (element.parents('.radio-inline').size() > 0) { 
                    error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                } else if (element.parents('.checkbox-list').size() > 0) {
                    error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                } else if (element.parents('.checkbox-inline').size() > 0) { 
                    error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
*/
            },

            // az invalidHandler akkor aktiválódik, ha elküldjük a formot és hiba van
            invalidHandler: function (event, validator) { //display error alert on form submit              
                var errors = validator.numberOfInvalids();
                toastr['error'](errors + ' mezőt nem megfelelően töltött ki!');
            },
            highlight: function (element) { // hightlight error inputs
                //console.log(element);
                $(element).closest('.form-group').addClass('has-error');
                $(element).addClass('has-error');                   
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                $(element).removeClass('has-error');                   
            },
            success: function (label) {
                //console.log(label);
                //label.closest('.form-group').removeClass('has-error').addClass("has-success"); // set success class to the control group
                label.closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function (form) {
                //adatok elküldése "normál" küldéssel
                //userdata_form.submit();
                
                changeNameOrEmail();
                // console.log('userdata form küldi');
            }
        });
    };









	return {
 
		//main method to initiate page
		init: function () {           
			// call local function
			deleteFollowed();
            handleValidation_password();
            handleValidation_userdata();
            //changePassword();
            //changeNameOrEmail();
		}

	};
}();

$(document).ready(function() {
	Profile.init();
});