var Allapot = function () {

    var handleTable = function () {

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
//            jqTds[0].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[0] + '">';
            jqTds[1].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[1] + '">';
            jqTds[2].innerHTML = '<a class="edit" href=""><i class="fa fa-check"></i> Mentés</a>';
            jqTds[3].innerHTML = '<a class="cancel" href=""><i class="fa fa-close"></i> Mégse</a>';
        }

        function saveRow(oTable, nRow, lastInsertId) {
            var jqInputs = $('input', nRow);
            if (lastInsertId > 0 && lastInsertId != true) {
                oTable.fnUpdate(lastInsertId, nRow, 0, false);
            }
            oTable.fnUpdate(jqInputs[0].value, nRow, 1, false);
            oTable.fnUpdate('<a class="edit" href=""><i class="fa fa-edit"></i> Szerkeszt</a>', nRow, 2, false);
            oTable.fnUpdate('<a class="delete" href=""><i class="fa fa-trash"></i> Töröl</a>', nRow, 3, false);
            oTable.fnDraw();
        }

        function cancelEditRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
//            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[0].value, nRow, 1, false);
            oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 2, false);
            oTable.fnDraw();
        }

        var table = $('#allapot');

        var oTable = table.dataTable({
            
            "language": {
                // metronic specific
                    //"metronicGroupActions": "_TOTAL_ sor kiválasztva: ",
                    //"metronicAjaxRequestGeneralError": "A kérés nem hajtható végre, ellenőrizze az internet kapcsolatot!",

                // data tables specific                
                "decimal":        "",
                "emptyTable":     "Nincs megjeleníthető adat!",
                "info":           "_START_ - _END_ elem &nbsp;/ _TOTAL_ elemből",
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
            "columnDefs": [
                {"orderable": true, "searchable": true, "targets": 0},
                {"orderable": true, "searchable": true, "targets": 1},
                {"orderable": false, "searchable": false, "targets": 2},
                {"orderable": false, "searchable": false, "targets": 3}
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "Összes"] // change per page values here
            ],
            "pageLength": 20,
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });



        var nEditing = null;
        var nNew = false;

        $('#allapot_new').click(function (e) {
            e.preventDefault();
            if (nNew || nEditing) {

                App.alert({
                    container: $('#ajax_message'), // $('#elem'); - alerts parent container(by default placed after the page breadcrumbs)
                    place: "append", // "append" or "prepend" in container 
                    type: 'warning', // alert's type (success, danger, warning, info)
                    message: "A szerkesztett elemet mentse el, vagy klikkel-jen a mégse gombra.", // alert's message
                    close: true, // make alert closable
                    reset: true, // close all previouse alerts first
                    // focus: true, // auto scroll to the alert after shown
                    closeInSeconds: 7, // auto close after defined seconds
                    icon: "warning" // put icon before the message
                });

            } else {
                var aiNew = oTable.fnAddData(['', '', '', '']);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
                nNew = true;
            }
        });


        // törlés
        table.on('click', '.delete', function (e) {
            e.preventDefault();
            reference = $(this);
            bootbox.setDefaults({
                locale: "hu",
            });
            bootbox.confirm("Biztosan törölni akarja?", function (result) {
                if (result) {

                    var ajax_message = $('#ajax_message');
                    var nRow = reference.parents('tr')[0];
                    var allapotId = $(reference.closest('tr')).find('td:first').html();
                    allapotId = $.trim(allapotId);
                    
                    $.ajax({
                        type: "POST",
                        data: {
                            id: allapotId,
                            action: 'delete',
                            table: 'ingatlan_allapot',
                            id_name: 'all_id'
                        },
                        url: "admin/datatables/ajax_delete",
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
                                
                                // sor törlése a DOM-ból    
                                oTable.fnDeleteRow(nRow);
                            }

                            if (result.status == 'error') {
                                App.alert({
                                    container: ajax_message, // $('#elem'); - alerts parent container(by default placed after the page breadcrumbs)
                                    place: "append", // "append" or "prepend" in container 
                                    type: 'danger', // alert's type (success, danger, warning, info)
                                    message: result.message, // alert's message
                                    close: true, // make alert closable
                                    reset: true, // close all previouse alerts first
                                    // focus: true, // auto scroll to the alert after shown
                                    closeInSeconds: 4 // auto close after defined seconds
                                    // icon: "warning" // put icon before the message
                                });   
                            }

                        },
                        error: function (result, status, e) {
                            console.log(errorThrown);
                            console.log("Hiba történt: " + textStatus);
                            console.log("Rendszerválasz: " + xhr.responseText);
                        }
                    });

                }

            });

        });

        // mégsem
        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });


        // edit, insert
        table.on('click', '.edit', function (e) {
            e.preventDefault();
            reference = $(this);
            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == '<i class="fa fa-check"></i> Mentés') {
                /* Editing this row and want to save it */

                bootbox.setDefaults({
                    locale: "hu",
                });
                bootbox.confirm("Biztosan menteni akarja a módosítást?", function (result) {
                    if (result) {

                        var ajax_message = $('#ajax_message');
                        var allapotId = $(reference.closest('tr')).find('td:first').html();
                        allapotId = $.trim(allapotId);
                        var data = $(reference.closest('tr')).find('input').val();
                        
                        $.ajax({
                            type: "POST",
                            data: {
                                id: allapotId,
                                action: 'update_insert',
                                table: 'ingatlan_allapot',
                                id_name: 'all_id',
                                leiras_name: 'all_leiras',
                                data: data
                            },
                            url: "admin/datatables/ajax_update_insert",
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
                                    
                                    App.alert({
                                        container: ajax_message, // $('#elem'); - alerts parent container(by default placed after the page breadcrumbs)
                                        place: "append", // "append" or "prepend" in container 
                                        type: 'success', // alert's type (success, danger, warning, info)
                                        message: result.message, // alert's message
                                        close: true, // make alert closable
                                        // reset: true, // close all previouse alerts first
                                        // focus: true, // auto scroll to the alert after shown
                                        closeInSeconds: 4 // auto close after defined seconds
                                        // icon: "warning" // put icon before the message
                                    });
                                    
                                    saveRow(oTable, nEditing, result.last_insert_id);
                                    nEditing = null;
                                    nNew = false;
                                }

                                if (result.status == 'error') {
                                    App.alert({
                                        container: ajax_message, // $('#elem'); - alerts parent container(by default placed after the page breadcrumbs)
                                        place: "append", // "append" or "prepend" in container 
                                        type: 'danger', // alert's type (success, danger, warning, info)
                                        message: result.message, // alert's message
                                        close: true, // make alert closable
                                        // reset: true, // close all previouse alerts first
                                        // focus: true, // auto scroll to the alert after shown
                                        closeInSeconds: 4 // auto close after defined seconds
                                        // icon: "warning" // put icon before the message
                                    });  
                                }
                            },
                            error: function (result, status, e) {
                                console.log(errorThrown);
                                console.log("Hiba történt: " + textStatus);
                                console.log("Rendszerválasz: " + xhr.responseText);
                            }
                        });
   
                    }
                });

            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleTable();
        }

    };

}();

jQuery(document).ready(function () {
    Allapot.init();
});