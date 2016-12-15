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
                //console.log('onSuccess metodus');
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
                        "metronicAjaxRequestGeneralError": "A kérés nem hajtható végre, ellenőrizze az internet kapcsolatot!",

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
                
                    {"name": "chechbox", "searchable": false, "orderable": false, "targets": 0},
                    {"name": "id", "searchable": true, "orderable": true, "targets": 1},
                    {"name": "kepek", "searchable": false, "orderable": false, "targets": 2},
                    {"name": "ref_id", "searchable": true, "orderable": true, "targets": 3},
                    {"name": "tipus", "searchable": true, "orderable": true, "targets": 4},
                    {"name": "kategoria", "searchable": true, "orderable": true, "targets": 5},
                    {"name": "varos", "searchable": true, "orderable": true, "targets": 6},
                    {"name": "alapterulet", "searchable": true, "orderable": true, "targets": 7},
                    {"name": "megtekintes", "searchable": false, "orderable": true, "targets": 8},
                    {"name": "ar_elado", "searchable": true, "orderable": true, "targets": 9},
                    {"name": "status", "searchable": true, "orderable": true, "targets": 10},
                    {"name": "menu", "searchable": false, "orderable": false, "targets": 11}
                
                ],
                
                // ha a php feldolgozó asszociatív tömböt ad vissza adatként (pl.: 'name' => 'László', 'age' => '38', 'haircolor' => 'blonde' ...), akkor meg kell adni az egyes elem nevét!    
                // (ha a php számmal indexelt tömböt ad vissza (pl.: 'László', '38', 'Blonde' ...), akkor nem kell ez a beállítás!) 
          
                "columns": [
                    { "data": "checkbox" },
                    { "data": "id" },
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

                "pageLength": 50, // default record count per page

                "ajax": {
                    "url": "admin/property/getpropertylist", // ajax source
                },
                
                //kikapcsolja mindenhol a sorbarendezés ikont (class="sorting_disable")
                //"ordering": false,
                
                "order": [
                    [1, "desc"]
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
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                App.alert({
                    type: 'danger',
                    //icon: 'warning',
                    message: 'Nem jelölt ki semmit!',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
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

    var show_filter_div = function() {

        $("#show_filter_td").on('click', function() {
            $('#filter_td').slideToggle();
        })
    };



    /**
     *	A részletek megjelenítéséhez használt modal
     *	AUTOMATIKUSAN ("HTML-elemmel" indul)
     */
/*    var handleModal = function () {
        $('#ajax_modal').on('hidden.bs.modal', function () {
            $('#modal_container').html('');
        });
    } */

    /**
     *	A részletek megjelenítéséhez használt modal
     *	JAVASCRIPT INDÍTÓVAL és SAJÁT MEGOLDÁSSAL működik
     */
    /* 
     var handleModal_2 = function() {
     //elindítja a folyamatot ha ráklikkel a részletek gombra
     $('.modal_trigger').on('click', function(e){
     e.preventDefault();
     var $id = $(this).attr('data-id');
     
     // AJAX kérés (a visszaadott html-t az ajax_modal elembe teszi (url, data, callback))
     $("#ajax_modal").load('admin/property/view_property_ajax', {"id": $id}, function(response, status, xhr) {
     if(status == 'success') {
     //a modal elem megjelenítése
     $("#ajax_modal").modal("show");
     } else {
     console.log('Hiba: ajax kérés nem sikerült!');
     }
     
     // ha ráklikkel a módosít gombra
     $('#job_update_button').on('click', function(){
     //$('#ajax_modal').modal("hide");
     window.location.href = 'admin/property/update/' + $id;
     });
     }); 
     });	
     }	
     */

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
            printTable();
            // handleModal();
            locationsInput();
            enableDistrict();

           
            vframework.changeStatus({
                url: "admin/property/change_status"
            });

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