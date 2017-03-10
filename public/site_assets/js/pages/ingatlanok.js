var Ingatlanok = function () {

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
     * Keresés mentése
     */
    var saveSearch = function () {

        $('#save_search').on('click', function(event){
            event.preventDefault();
            
            var gomb = $(this);

            // ha már van disabled osztálya a gombnak
            if ($(gomb).hasClass('disabled')) {
                return false;
            }

            // url
            var searchurl = window.location.href;

            $.ajax({
                url: '/kereses/savesearch',
                type: 'post',
                dataType: 'json',
                data: {url: searchurl},
            
                beforeSend: function() {
                    /*
                    App.blockUI({
                        boxed: true,
                        message: 'Feldolgozás...'
                    });
                    */

                },
                complete: function(){
                    /*
                    App.unblockUI();
                    */
                },
                // itt kapjuk meg (és dolgozzuk fel) a feldolgozó php által visszadott adatot 
                success: function(result){
                    if(result.status == 'success'){
                        // disabled-re állítjuk a gombot
                        $(gomb).addClass('disabled');
                        // üzenet megjelenítése
                        toastr['success'](result.message);
                    }
            
                    if(result.status == 'error'){
                        // üzenet megjelenítése
                        toastr['error'](result.message);
                    }
            
                },
                error: function(result, status, e){
                    console.log(e);
                } 
            });

        });

    }; 

    var equalHeights = function () {
        setTimeout(function () {
            $('#equalheight-property-list div.item').equalHeights();
        }, 200);
    };

    return {
        //main function to initiate the module
        init: function () {
            saveSearch();
            equalHeights();
        }
    };
}();

jQuery(document).ready(function ($) {
    Ingatlanok.init();
});