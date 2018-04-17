/**
 Property oldal
 **/
var Property = function () {

    var propertyTable = function() {
        
        var grid = new Datatable();

        grid.init({
            src: $("#property"),
            onSuccess: function (grid) {
                // execute some code after table records loaded
                // console.log('onSuccess metodus');
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            loadingMessage: 'Betöltés...',
            dataTable: {
                //"autoWidth": false,

                "language": {
                    //url: "public/admin_assets/plugins/datatables/plugins/i18n/Hungarian.json"

                    // metronic specific
                        "metronicGroupActions": "_TOTAL_ sor kiválasztva: ",
                        "metronicAjaxRequestGeneralError": "Hiba történt, a kérés nem hajtható végre!",

                    // data tables specific                
                    "decimal":        "",
                    "emptyTable":     "Nincs megjeleníthető adat!",
                    "info":           "_START_ - _END_ elem &nbsp; _TOTAL_ elemből",
                    "infoEmpty":      "Nincs megjeleníthető adat!",
                    "infoFiltered":   "(Szűrve _MAX_ elemből)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     " _MENU_ elem/oldal &nbsp;",
                    "loadingRecords": "Betöltés...",
                    "processing":     "Feldolgozás...",
                    "search":         "Keresés:",
                    "zeroRecords":    "Nincs egyező elem",
                    "paginate": {
                        "previous":   "Előző",
                        "next":       "Következő",
                        "last":       "Utolsó",
                        "first":      "Első",
                        "pageOf":     "&nbsp;/&nbsp;"
                    },
                    "aria": {
                        "sortAscending":  ": aktiválja a növekvő rendezéshez",
                        "sortDescending": ": aktiválja a csökkenő rendezéshez"
                    }

                },

                // A php feldolgozónak küld a táblázatról információkat, azért hogy a szerver a megfelelő adatokat adhasson vissza pl. szűrésnél
                "columnDefs": [
                    {"name": "checkbox", "searchable": false, "orderable": false, "targets": 0},
                    {"name": "notice", "searchable": false, "orderable": false, "targets": 1},
                    {"name": "id", "searchable": true, "orderable": true, "targets": 2, "visible": false},
                    {"name": "ref_num", "searchable": true, "orderable": true, "targets": 3},
                    {"name": "kepek", "searchable": false, "orderable": false, "targets": 4},
                    {"name": "ref_id", "searchable": true, "orderable": true, "targets": 5},
                    {"name": "tipus", "searchable": true, "orderable": true, "targets": 6},
                    {"name": "kategoria", "searchable": true, "orderable": true, "targets": 7},
                    {"name": "varos", "searchable": true, "orderable": true, "targets": 8},
                    {"name": "alapterulet", "searchable": true, "orderable": true, "targets": 9},
                    {"name": "megtekintes", "searchable": false, "orderable": false, "targets": 10},
                    {"name": "ar", "searchable": true, "orderable": false, "targets": 11},
                    {"name": "status", "searchable": true, "orderable": true, "targets": 12},
                    {"name": "menu", "searchable": false, "orderable": false, "targets": 13}
                ],
                
                // ha a php feldolgozó asszociatív tömböt ad vissza adatként (pl.: 'name' => 'László', 'age' => '38', 'haircolor' => 'blonde' ...), akkor meg kell adni az egyes elem nevét!    
                // (ha a php számmal indexelt tömböt ad vissza (pl.: 'László', '38', 'Blonde' ...), akkor nem kell ez a beállítás!) 
          
                "columns": [
                    { "data": "checkbox" },
                    { "data": "notice" },
                    { "data": "id" },
                    { "data": "ref_num" },
                    { "data": "kepek" },
                    { "data": "ref_id" },
                    { "data": "tipus" },
                    { "data": "kategoria" },
                    { "data": "varos" },
                    { "data": "alapterulet" },
                    { "data": "megtekintes" },
                    { "data": "ar" },
                    { "data": "status" },
                    { "data": "menu" }
                ],      

                "lengthMenu": [
                    [10, 20, 50, 100, 150],
                    [10, 20, 50, 100, 150] // change per page values here 
                ],

                //"autoWidth": false,

                "pageLength": 50, // default record count per page

                "ajax": {
                    "url": "admin/property/getpropertylist", // ajax source
                },
                
                //kikapcsolja mindenhol a sorbarendezés ikont (class="sorting_disable")
                //"ordering": false,
                
                "order": [
                    [3, "desc"]
                ] // set first column as a default sort by asc
            }
        });


         // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
            
                var confirm_str = '';

                if(action.val() == 'group_make_active'){
                    confirm_str = "Biztosan végre akarja hajtani az aktiválását?";
                }
                else if(action.val() == 'group_make_inactive'){
                    confirm_str = "Biztosan végre akarja hajtani az inaktiválást?";
                }
                else if(action.val() == 'group_delete'){
                    confirm_str = "Biztosan törölni akarja a rekordot?";
                }
                else if(action.val() == 'group_make_highlight'){
                    confirm_str = "Biztosan végre akarja hajtani a kiemelést?";
                }
                else if(action.val() == 'group_delete_highlight'){
                    confirm_str = "Biztosan törölni akarja a kiemelést?";
                }
                // referens áthelyezésnél lesz ez az eset
                else {
                    confirm_str = "Biztosan végre akarja hajtani a műveletet?";
                }
                
                bootbox.setDefaults({
                    locale: "hu", 
                });
                bootbox.confirm(confirm_str, function(result) {
                    if (result) {

                        grid.setAjaxParam("customActionType", "group_action");
                        grid.setAjaxParam("customActionName", action.val());
                        grid.setAjaxParam("id", grid.getSelectedRows());
                        grid.getDataTable().ajax.reload();
                        grid.clearAjaxParams();
                
                    }
                });             
            
            } else if (action.val() == "") {
                App.alert({
                    type: 'danger',
                    //icon: 'warning',
                    message: 'Válasszon csoportműveletet!',
                    container: grid.getTableWrapper(),
                    place: 'prepend',
                    //closeInSeconds: 10 // auto close after defined seconds
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                App.alert({
                    type: 'danger',
                    //icon: 'warning',
                    message: 'Nem jelölt ki semmit!',
                    container: grid.getTableWrapper(),
                    place: 'prepend',
                    //closeInSeconds: 10 // auto close after defined seconds
                });
            }
        });

    };


/*
    var resetSearchForm = function () {
        $('#reset_search_form').on('click', function () {
            $(':input', '#property_search_form')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');
        });
    };
*/

    var changeKiemelesConfirm = function () {
        $('table#property').on('click', '.change_kiemeles', function (e) {
            e.preventDefault();
            var action = $(this).attr('data-action');
            var propertyId = $(this).attr('data-id');
            var elem = this;
            //var propertyName = $(this).closest("tr").find('td:nth-child(2)').text();

            bootbox.setDefaults({
                locale: "hu",
            });
            bootbox.confirm("Biztosan módosítani akarja az ingatlan kiemelését?", function (result) {
                if (result) {
                    changeKiemeles(propertyId, action, elem);
                }
            });
        });
    };

    var changeKiemeles = function (propertyId, action, elem) {
//console.log(elem);
        $.ajax({
            type: "POST",
            data: {
                id: propertyId,
                action: action
            },
            url: "admin/property/change_kiemeles",
            dataType: "json",
            beforeSend: function () {
                App.blockUI({
                    boxed: true,
                    message: 'Feldolgozás...'
                });
            },
            complete: function () {
                App.unblockUI();
            },
            success: function (result) {
                if (result.status == 'success') {
                    if (action == 'delete_kiemeles') {
                        $(elem).html('<i class="fa fa-plus-circle"></i> Kiemelés');
                        $(elem).attr('data-action', 'add_kiemeles');
                        $(elem).closest('tr').find('td:nth-child(2) span').remove();
                        // $('#id_element_' + propertyId + ' span').remove();
                        
                        App.alert({
                            type: 'success',
                            //icon: 'warning',
                            message: "Az ingatlan kiemelése törölve!",
                            container: ajax_message,
                            place: 'append',
                            close: true, // make alert closable
                            reset: false, // close all previouse alerts first
                            //focus: true, // auto scroll to the alert after shown
                            closeInSeconds: 3 // auto close after defined seconds
                        });

                    }
                    else if (action == 'add_kiemeles') {
                        $(elem).html('<i class="fa fa-minus-circle"></i> Kiemelés törlése');
                        $(elem).attr('data-action', 'delete_kiemeles');
                        $(elem).closest('tr').find('td:nth-child(2)').append('<span class="label label-sm label-success">Kiemelt</span>');
                        //$('#id_element_' + propertyId).append('<span class="label label-sm label-success">Kiemelt</span>');
                        
                        App.alert({
                            type: 'success',
                            //icon: 'warning',
                            message: "Az ingatlan kiemelve!",
                            container: ajax_message,
                            place: 'append',
                            close: true, // make alert closable
                            reset: false, // close all previouse alerts first
                            //focus: true, // auto scroll to the alert after shown
                            closeInSeconds: 3 // auto close after defined seconds
                        });

                    }

                } else {
                    console.log('Hiba: az adatbázis művelet nem történt meg!');
                    App.alert({
                        type: 'warning',
                        //icon: 'warning',
                        message: 'Adatbázis hiba! Az ingatlan státusza nem változott meg!',
                        container: ajax_message,
                        place: 'append',
                        close: true, // make alert closable
                        reset: false, // close all previouse alerts first
                        //focus: true, // auto scroll to the alert after shown
                        closeInSeconds: 3 // auto close after defined seconds
                    });                    
                }
            },
            error: function (result, status, e) {
                console.log(e);
            }
        });
    };





    var locationsInput = function () {

        //kerület és városrész option lista megjelenítése, ha a kiválasztott megye Budapest
        $("#megye_select").change(function () {
            var str = "";
            //option listaelem tartalom
            str = $("select#megye_select option:selected").text();
            // option listaelem value
            option_value = $("select#megye_select option:selected").val();

            // az érték üres lesz, ha a válassz elemet választjuk ki az option listából
            if (option_value !== '') {

                var county_id = $("#megye_select").val();

                $.ajax({
                    type: "post",
                    url: "admin/property/county_city_list",
                    data: "county_id=" + county_id,
                    beforeSent: function () {
                        App.blockUI({
                            boxed: true,
                            message: 'Feldolgozás...'
                        });
                    },
                    complete: function () {
                        App.unblockUI();
                    },
                    success: function (data) {
                        //console.log(data);
                        $("#varos_div > select").html(data);
                    }
                });

            }


        })
    };

    var enableDistrict = function () {

        //kerület és városrész option lista megjelenítése, ha a kiválasztott megye Budapest
        $("#megye_select").change(function () {
            var str = "";

            //option listaelem tartalom
            str = $("select#megye_select option:selected").text();
            // option listaelem value
            option_value = $("select#megye_select option:selected").val();


            // az érték üres lesz, ha a válassz elemet választjuk ki az option listából
            if (option_value === '5') {
                $('#district_select').prop("disabled", false);
            }
            else {
                $('#district_select').prop("disabled", true);
            }

        })
    };

/*
    var printTable = function () {
        $('#print_property').on('click', function (e) {
            e.preventDefault();
            var divToPrint = document.getElementById("property");
            console.log(divToPrint);
//		divToPrint = $('#property tr').find('th:last, td:last').remove();
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        })

    };
*/    

    var show_filter_div = function() {

        $("#show_filter_td").on('click', function() {
            $('#filter_td').slideToggle();
        })
    };



    /**
     * Egy elem klónozása ajax-al confirm
     */
    var cloneConfirm = function () {
        $('table#property').on('click', '.clone_item', function(e){
            e.preventDefault();
            //var name = $(this).closest("tr").find('td:nth-child(3)').text();
            var id = $(this).attr('data-id'); // a klónozandó elem id-je
            bootbox.setDefaults({
                locale: "hu", 
            });
            bootbox.confirm('Biztosan klónozni akara a rekordot?', function(result) {
                if (result) {
                    _cloneItem(id);
                }
            }); 
        }); 
    };

    /**
     * Ingatlan klónozása
     * @param id - rekord id-je
     */
    var _cloneItem = function (id) {

        $.ajax({
            url: 'admin/property/cloning',
            type: 'POST',
            dataType: 'json',
            data: {
                item_id: id
            },
            beforeSend: function() {
                App.blockUI({
                    boxed: true,
                    message: 'Feldolgozás...'
                });
            },
            complete: function(){
                App.unblockUI();
            },
            success: function (result) {
                if (result.status == 'success') {
                    // datatable objektum hozzárendelése a table változóhoz
                    var table = $('#property').DataTable();

                    // A táblázat újrarajzolása
                    table.draw();

                    App.alert({
                        type: 'success',
                        //icon: 'warning',
                        message: result.message,
                        container: ajax_message,
                        place: 'append',
                        close: true, // make alert closable
                        reset: false, // close all previouse alerts first
                        //focus: true, // auto scroll to the alert after shown
                        closeInSeconds: 3 // auto close after defined seconds
                    });                                

                
                }    
                else if (result.status == 'error') {
                    App.alert({
                        type: 'danger',
                        //icon: 'warning',
                        message: result.message,
                        container: ajax_message,
                        place: 'append',
                        close: true, // make alert closable
                        //reset: false, // close all previouse alerts first
                        //focus: true, // auto scroll to the alert after shown
                        closeInSeconds: 5 // auto close after defined seconds
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown){
                console.log(errorThrown);
                console.log("Hiba történt: " + textStatus);
                console.log("Rendszerválasz: " + xhr.responseText); 
            } 
        }); // ajax end
    };

    /**
     *
     */
    var notice = function(){
        // a kijelölt elemek id-jét tartalamzó tömb
        var id_array = new Array();

        // bejelölt checkboxokat tartalmazó objektum        
        var checkboxes;

        // összes notice_checkboxes törlése
        var resetNoticeCheckboxes = function(){
            var set = '#property .notice_checkboxes';
            $(set).each(function () {
                $(this).prop("checked", false);
            });
            $.uniform.update(set);
        }


        // modal megjelenítése
        $("#show_email_modal").on('click', function(){
            id_array = [];

            // a kijelölt checkboxok            
            checkboxes = $("input[name='notice']:checked");    
            // bejárjuk a checkboxokat tartalmazó objektumot
            $.each(checkboxes, function(index, val) {
                //if( $(this).is(':checked') ){}
                id_array.push($(this).val());
            });

            if (id_array.length == 0) {
                App.alert({
                    type: 'danger',
                    //icon: 'warning',
                    message: 'Jelöljön ki egy ingatlant!',
                    container: ajax_message,
                    place: 'append',
                    close: true, // make alert closable
                    reset: false, // close all previouse alerts first
                    //focus: true, // auto scroll to the alert after shown
                    closeInSeconds: 3 // auto close after defined seconds
                });
            } else {
                // modal megjelenítése
                $('#email_send_modal').modal('show');
            }


        });

        // form adatok küldése
        $('#ingatlan_adatok_form').on('submit', function(e){
            e.preventDefault();

            // email cím
            var email = $("input[name='email']").val();
            // név
            var name = $("input[name='name']").val();
            // név
            var message = $("textarea[name='message']").val();

            // adatok küldése
            $.ajax({
                url: 'admin/property/sendemail',
                type: 'POST',
                dataType: 'json',
                
                data: {
                    id_array: id_array, 
                    name: name, 
                    email: email, 
                    message: message
                },
            
                beforeSend: function() {
                    
                    // modal bezárása
                    $('#email_send_modal').modal('hide');

                    App.blockUI({
                        boxed: true,
                        message: 'Feldolgozás...'
                    });
                },
                complete: function(){
                    App.unblockUI();
                    // checkboxes reset
                    resetNoticeCheckboxes();
                    // form reset
                    document.getElementById("ingatlan_adatok_form").reset();    
                },
                // itt kapjuk meg (és dolgozzuk fel) a feldolgozó php által visszadott adatot 
                success: function(result){
                    if(result.status == 'success'){
                        App.alert({
                            type: 'success',
                            //icon: 'warning',
                            message: result.message,
                            container: ajax_message,
                            place: 'append',
                            close: true, // make alert closable
                            reset: false, // close all previouse alerts first
                            //focus: true, // auto scroll to the alert after shown
                            closeInSeconds: 3 // auto close after defined seconds
                        });
                    }

                    if(result.status == 'error'){
                        App.alert({
                            type: 'danger',
                            //icon: 'warning',
                            message: result.message,
                            container: ajax_message,
                            place: 'append',
                            close: true, // make alert closable
                            reset: false, // close all previouse alerts first
                            //focus: true, // auto scroll to the alert after shown
                            closeInSeconds: 3 // auto close after defined seconds
                        }); 
                    }
            
                },
                error: function(result, status, e){
                    console.log(e);
                } 
            });

  


        });

    };

    /**
     * Adatalap nyomtatás
     */
    var adatlapNyomtatas = function () {

        $('table#property').on('click', '.generate_pdf', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id'); // az elem id-je
            $("#generate_pdf_form_" + id).submit();
        });

    };


    return {
//main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

            propertyTable();

            show_filter_div();
            //enableDisableButtons();
            // resetSearchForm();
            changeKiemelesConfirm();
            //printTable();
            // handleModal();
            locationsInput();
            enableDistrict();
            cloneConfirm();
            notice();
            adatlapNyomtatas();
           
            vframework.changeStatus({
                url: "admin/property/change_status"
            });

            vframework.printTable({
                print_button_id: "print_property", // elem id-je, amivel elindítjuk a nyomtatást 
                table_id: "property",
                title: "Ingatlanok listája"
            });

            /**
             * Egy elem törlése
             */
            vframework.deleteItems({
                table_id: "property",
                url: "admin/property/softdelete",
                confirm_message: "Biztosan törölni akarja az ingatlant?"
            });

            vframework.hideAlert();




        }

    };
}();

$(document).ready(function () {
    Property.init(); // init property page
});