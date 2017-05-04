var DeletedProprety = function () {

    var deleted_propertyTable = function () {

        var table = $('#deleted_property');

        table.dataTable({

            "language": {
                // metronic specific
                    //"metronicGroupActions": "_TOTAL_ sor kiválasztva: ",
                    //"metronicAjaxRequestGeneralError": "A kérés nem hajtható végre, ellenőrizze az internet kapcsolatot!",
                // data tables specific                
                "decimal":        "",
                "emptyTable":     "Nincs megjeleníthető adat!",
                "info":           "_START_ - _END_ elem &nbsp; _TOTAL_ elemből",
                "infoEmpty":      "Nincs megjeleníthető adat!",
                "infoFiltered":   "(Szűrve _MAX_ elemből)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     " _MENU_ elem/oldal",
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

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            // "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            "lengthMenu": [
                [10, 20, 50, -1],
                [10, 20, 50, "Összes"] // change per page values here
            ],
            // set the initial value
            "pageLength": 50,            
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {'orderable': false, 'searchable': false, 'targets': 0}, //chechkbox
                {'orderable': true, 'searchable': false, 'targets': 1}, //id
                {'orderable': true, 'searchable': true, 'targets': 2}, //ref szám
                {'orderable': false, 'searchable': false, 'targets': 3}, //kép
                {'orderable': true, 'searchable': true, 'targets': 4}, //referens név
                {'orderable': true, 'searchable': false, 'targets': 5}, //típus
                {'orderable': true, 'searchable': true, 'targets': 6}, //kategória
                {'orderable': true, 'searchable': true, 'targets': 7}, //város
                {'orderable': true, 'searchable': false, 'targets': 8}, //ár
                {'orderable': false, 'searchable': false, 'targets': 9} //menü
            ],
            "order": [
                [1, "asc"]
            ] // set column as a default sort by asc
        });


        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).prop("checked", true);
                } else {
                    $(this).prop("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });
    };

    /**
     * Egy elem helyreállítása - confirm
     */
    var redoOneConfirm = function () {
        $('table#deleted_property' ).on('click', '.redo_item', function(e){
            e.preventDefault();
            //var name = $(this).closest("tr").find('td:nth-child(3)').text();
            var id = $(this).attr('data-id'); // a törlendő elem id-je
            var id_arr = [id]; // berakjuk egy tömbbe az id-t
            var deleteRow = $(this).closest("tr"); // a deleteHtml változóhoz rendeljük a html táblázat törlendő sorát <tr>
            
            bootbox.setDefaults({
                locale: "hu", 
            });
            bootbox.confirm('Biztosan helyre akarja állítani az ingatlant?', function(result) {
                if (result) {
                    _redo_item(id_arr, deleteRow);
                }
            }); 
        }); 
    };

    /**
     * Elemek csoportos helyreállítása - confirm
     */
    var redoGroupConfirm = function () {
        $('#redo_group').on('click', function(){

            var id_array = new Array(); // a törlendő id-ket tartalamzó tömb
            var checkboxes = $('#deleted_property input.checkboxes'); // a táblában lévő checkbox objektumok

            // bejárjuk a checkboxokat tartalmazó objektumot
            $.each(checkboxes, function(index, val) {
                if( $(this).is(':checked') ){
                    // ha be van kapcsolva az aktuális checkbox, akkor a value értékét berakjuk a id_array tömbbe
                    id_array.push($(this).val());
                }
            });

            // ellenőrizzük, hogy be van-e jelölve checkbox (ha az id_array tömb üres nincs bejelölve semmi)
            if(id_array.length == 0){
                App.alert({
                    type: 'warning',
                    icon: 'warning',
                    message: "&nbsp;Nincs elem kiválasztva!",
                    container: ajax_message,
                    place: 'append',
                    close: true, // make alert closable
                    //reset: true, // close all previouse alerts first
                    //focus: true, // auto scroll to the alert after shown
                    closeInSeconds: 3 // auto close after defined seconds
                });
            }
            else {
                bootbox.setDefaults({
                    locale: "hu", 
                });
                bootbox.confirm('Biztosan helyre akarja állítani a kijelölt ingatlanokat?', function(result) {
                    if (result) {
                        // a második paraméter a törlendő html elem, de csoportos törlésnél null
                       _redo_item(id_array, null);
                    }
                });
            }

        });

    };  

    /**
     * Rekordok törlésének visszaállítása
     *
     * @param array                 id_array    visszaállítandó id-ket tartalamzó tömb
     * @param objektum vagy null    deleteRow   HTML elem, amit törölni kell a dom-ból (csoportos törlésnél null az értéke!)
     */
    var _redo_item = function (id_array, deleteRow) {

        $.ajax({
            url: 'admin/property/cancel_delete',
            type: 'POST',
            dataType: 'json',
            data: {
                item_id: id_array
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
                    var table = $('#deleted_property').DataTable();

                    // HTML elemek törlése a DOM-ból (csoportos törlésnél a deleteRow-nak null az értéke)
                    if(deleteRow != null){
                        // HTML táblázat sorának kiválasztása, törlése, és a táblázat újrarajzolása
                        table.row( deleteRow ).remove().draw();
                    }
                    else {
                        var checkboxes = $('#deleted_property input.checkboxes');
                        $.each(checkboxes, function(index, val) {
                            if( $(this).is(':checked') ){
                                // HTML táblázat aktuális sorának kiválasztása, törlése
                                table.row( $(this).closest("tr") ).remove();
                            }
                            // A táblázat újrarajzolása
                            table.draw();
                        }); 
                    }


                    if(result.message_success) {
                        App.alert({
                            type: 'success',
                            //icon: 'warning',
                            message: result.message_success,
                            container: ajax_message,
                            place: 'append',
                            close: true, // make alert closable
                            reset: false, // close all previouse alerts first
                            //focus: true, // auto scroll to the alert after shown
                            closeInSeconds: 3 // auto close after defined seconds
                        });                                
                    }
                    if (result.message_error) {
                        App.alert({
                            type: 'warning',
                            //icon: 'warning',
                            message: result.message_error,
                            container: ajax_message,
                            place: 'append',
                            close: true, // make alert closable
                            reset: false, // close all previouse alerts first
                            //focus: true, // auto scroll to the alert after shown
                            closeInSeconds: 3 // auto close after defined seconds
                        });  
                    }
                
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


    return {

        //main function to initiate the module
        init: function () {

            deleted_propertyTable();

            redoOneConfirm();
            redoGroupConfirm();

            // a csoportos és egy elem törlését kezeli
            vframework.deleteItems({
                table_id: "deleted_property",
                url: "admin/property/delete",
                confirm_message: "Véglegesen törölni akarja az ingatlant?",
                confirm_message_group: "Véglegesen törölni akarja az ingatlanokat?"                
            });

            vframework.hideAlert();

        }

    };

}();

$(document).ready(function() {
	DeletedProprety.init();
});