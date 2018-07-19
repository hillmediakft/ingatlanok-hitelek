var District_list = function () {
console.log(global_agents_list);

    /**
     * Táblázat oszlop indexek és egyéb beállítások megadása 
     *
     * tableID ->       html tábla elem id-je
     * insertButtonID -> új elem hozzáadása gomb azonosítója
     *
     * tableSetup ->    datatable táblázat beállításai
     *
     * colNumbers ->    Táblázat összes oszlopának száma.
     * modCols ->       Ezeknek az oszlopoknak az adatai módosíthatók!
     *                  A modCols elem kulcsai lehetnek bármilyen nevűek (a feldolgozáskor csak az értékre van szükség)
     * anotherCols ->   Azok az oszlopok amik nem módosulnak (ha vannak ilyenek).
     *                  Akkor kell neki értéket adni, ha új elem létrehozásakor akarunk egy default értéket adni egy oszlopnak. (pl.: bejegyzések száma - 0 vagy nincs)  
     *                  Ha nincsenek ilyen oszlopok, vagy új elem létrehozásakor nem kell default érték akkor hagyjuk üresen!  
     *                  Ez az elem is egy objektum! Minden elem tartalmaz egy objektumot ami megadja az oszlop számát és a default értékét.
     *                  Pl:
     *                      ez_a_nev_barmi_lehet: {
     *                          column: 3,
     *                          default_value: "0"
     *                      },
     *
     * urlInsert ->     a php feldolgozónak az url-je ami végrehajtja az új elem hozzáadást és módosítást
     * urlUpdate ->     a php feldolgozónak az url-je ami végrehajtja azelem módosítást
     * urlDelete ->     a php feldolgozónak az url-je ami végrehajtja a törlést
     *   
     */
    var setup = {
        tableID: "#districts",
        insertButtonID: "#insert_button",

        tableSetup: {

            "language": {
                // metronic specific
                //"metronicGroupActions": "_TOTAL_ sor kiválasztva: ",
                //"metronicAjaxRequestGeneralError": "A kérés nem hajtható végre, ellenőrizze az internet kapcsolatot!",

                // data tables specific                
                "decimal": "",
                "emptyTable": "Nincs megjeleníthető adat!",
                "info": "_START_ - _END_ elem &nbsp;/ _TOTAL_ elemből",
                "infoEmpty": "Nincs megjeleníthető adat!",
                "infoFiltered": "(Szűrve _MAX_ elemből)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": " _MENU_ elem/oldal",
                "loadingRecords": "Betöltés...",
                "processing": "Feldolgozás...",
                "search": "Keresés:",
                "zeroRecords": "Nincs egyező elem",
                "paginate": {
                    "previous": "Előző",
                    "next": "Következő",
                    "last": "Utolsó",
                    "first": "Első",
                    "pageOf": "&nbsp;/&nbsp;"
                },
                "aria": {
                    "sortAscending": ": aktiválja a növekvő rendezéshez",
                    "sortDescending": ": aktiválja a csökkenő rendezéshez"
                }
            },

            // set default column settings
            "columnDefs": [
                {"orderable": true, "searchable": true, "targets": 0},
                {"orderable": true, "searchable": true, "targets": 1},
                {"orderable": false, "searchable": false, "targets": 2},
                {"orderable": false, "searchable": false, "targets": 3}
            ],
            // save datatable state(pagination, sort, etc) in cookie.
            "bStateSave": true,
            // change per page values here
            "lengthMenu": [
                [50, 100, 250, -1],
                [50, 100, 250, "Összes"]
            ],
            // set the initial value
            "pageLength": 250,            
            "pagingType": "bootstrap_full_number",
            "order": [
                [0, "asc"]
            ] // set column as a default sort by asc            

        },

    // táblázat oszlop elrendezés
        colNumbers: 4,
        modCols: {
            district_name: 0,
            agent_name: 1
        },
        anotherCols: {

        },
        controlCols: {
            edit_save: 2,
            delete_cancel: 3
        },

    // feldolgozó url-ek
        urlInsert: "admin/datatables/district_insert_update",
        urlUpdate: "admin/datatables/district_insert_update",
        urlDelete: "admin/datatables/district_delete"
    };



    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

            DatatableEditable.init(setup);

            vframework.hideAlert();
            vframework.printTable({
                print_button_id: "print_district", // elem id-je, amivel elindítjuk a nyomtatást 
                table_id: "districts",
                title: "Budapest kerületek"
            });
        },

 
    };

}();


var DatatableEditable = function () {

    var setup;
    var table;
    var oTable;
    var nEditing = null;
    var nNew = false;


    /**
     *  Setup beállítása
     */
    var initOptions = function(options) {
        setup = options;
    }

    /**
     * Inicialzálja a datatable objektumot
     * ------- Táblázat beállítások ------
     */
    var initDataTable = function() {
        table = $(setup.tableID);
        oTable = table.dataTable(setup.tableSetup);     
    }


    // ------ ALAPFÜGGVÉNYEK ------------
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

                // Kerület neve oszlop
                    jqTds[setup.modCols.district_name].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[setup.modCols.district_name] + '">';

                // Referens select lista oszlop
                    // referens adatokat tartalmazó tömb
                    var agents = global_agents_list;
                    // a megye select lista td eleme
                    var agent_select_list_td = jqTds[setup.modCols.agent_name];
                    // a select lista td elem data-agent-id attribútuma (vagyis a kiválasztott elem)
                    var selectedAgentID = $(agent_select_list_td).attr('data-agent-id');

                    // referens option lista
                    var html_agent_list = '';
                    html_agent_list += '<select class="form-control select_agent"> \r\n';
                    html_agent_list += '<option value="">-- Válasszon --</option> \r\n';
                    var selected_agent = '';
                    $.each(agents, function(index, value){
                        selected_agent = (selectedAgentID == value["id"]) ? 'selected' : '';
                        html_agent_list += '<option value="' + value["id"] + '" ' + selected_agent + '>' + value["first_name"] + ' ' + value["last_name"] + '</option> \r\n';
                        selected_agent = '';
                    });

                    html_agent_list += '</select> \r\n';

                    // Referens neve a td elembe
                    jqTds[setup.modCols.agent_name].innerHTML = html_agent_list;


            // Controll oszlopok (szerkeszt, mégsem)    
                jqTds[setup.controlCols.edit_save].innerHTML = '<a class="edit" href=""><i class="fa fa-check"></i> Mentés</a>';
                jqTds[setup.controlCols.delete_cancel].innerHTML = '<a class="cancel" href=""><i class="fa fa-close"></i> Mégse</a>';
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);

            // Kerület név oszlop update-elése
                oTable.fnUpdate(jqInputs[setup.modCols.district_name].value, nRow, setup.modCols.district_name, false);

            // Referens elem frissítése
                // a td elem amiben a referens select lista van (ennek az elemnek a data-agent-id attribútumát kell majd módosítani)
                var agent_select_list_td = $(nRow).find('td')[setup.modCols.agent_name];
                var agentName = $('select.select_agent :selected').text();
                var agentID = $('select.select_agent').val(); // a kiválasztott referens id meghatározása
                
                // ha nem volt kiválasztva referens                
                if (agentID == '') {
                    agentName = '';
                }

                // A td elem data-agent-id attribútumának módosítása
                $(agent_select_list_td).attr('data-agent-id', agentID);
                // sor adatok frissítése
                oTable.fnUpdate(agentName, nRow, setup.modCols.agent_name, false);


            // Kontroll mezők frissítése    
                oTable.fnUpdate('<a class="edit" href=""><i class="fa fa-edit"></i> Szerkeszt</a>', nRow, setup.controlCols.edit_save, false);
                oTable.fnUpdate('<a class="delete" href=""><i class="fa fa-trash"></i> Töröl</a>', nRow, setup.controlCols.delete_cancel, false);
                oTable.fnDraw();
            }

            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                
                //bejárjuk a módosítható mezők oszlop indexét tartalmazó objektumot
                $.each(setup.modCols, function(index, val) {
                    oTable.fnUpdate(jqInputs[val].value, nRow, val, false);
                });             

                oTable.fnUpdate('<a class="edit" href=""><i class="fa fa-edit"></i> Szerkeszt</a>', nRow, setup.controlCols.edit_save, false);
                oTable.fnDraw();
            }
    // ------ ALAPFÜGGVÉNYEK VÉGE ------------



    // ------ ALAPFÜGGVÉNYEK ADDONS ------------
       
            /**
             * Minden sort töröl a táblázatból
             */
            function _deleteAllRows(oTable) {

                // bejárjuk a táblázat tr elemeit és egyenként töröljük őket
                $('table tbody > tr').each(function(index, nRow) {
                    // sor törlése a DOM-ból
                    oTable.fnDeleteRow(nRow);
                });

            }


    // ------ ALAPFÜGGVÉNYEK ADDONS VÉGE ------------


    /**
     * Elem hozzáadása
     */
    var initInsert = function() {

        $(setup.insertButtonID).click(function (e) {
            e.preventDefault();

            // ha van szerkesztett elem, VAGY létre van hozva egy új hozzáadása elem
            if (nNew || nEditing) {
                
                App.alert({
                    container: $('#ajax_message'), // $('#elem'); - alerts parent container(by default placed after the page breadcrumbs)
                    place: "append", // "append" or "prepend" in container 
                    type: 'warning', // alert's type (success, danger, warning, info)
                    message: "A szerkesztett elemet mentse el, vagy klikkel-jen a mégse gombra.", // alert's message
                    close: true, // make alert closable
                    reset: true, // close all previouse alerts first
                    // focus: true, // auto scroll to the alert after shown
                    closeInSeconds: 10 // auto close after defined seconds
                    // icon: "warning" // put icon before the message
                });
                
                return false;
                
            }
            
            // legyártjuk az üres stringeket tartalmazó tömböt
            var $temp = new Array(); 
            for (var i = 0; i < setup.colNumbers; i++) {
                $temp.push("");
            }

            var aiNew = oTable.fnAddData($temp);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;

        });
    }

    /**
     * Elem törlése
     */
    var initDelete = function() {
     
        table.on('click', '.delete', function (e) {
            e.preventDefault();
            reference = $(this);
//console.log(reference.parents('tr')[0]);          
            bootbox.setDefaults({
                locale: "hu"
            });
            bootbox.confirm("Biztosan törölni akarja?", function (result) {
                if (result) {

                    var nRow = reference.parents('tr')[0];
                    var id = reference.closest('tr').attr('data-id');
                    var ajax_message = $('#ajax_message');
                    
                    // az alap kerületek nem törölhetőek
                    if(id < 24) {
                        App.alert({
                            type: 'danger',
                            //icon: 'warning',
                            message: 'Ez a kerület nem törölhető!',
                            container: ajax_message,
                            place: 'append',
                            close: true, // make alert closable
                            reset: true, // close all previouse alerts first
                            //focus: true, // auto scroll to the alert after shown
                            closeInSeconds: 4 // auto close after defined seconds
                        });
                        return true;                        
                    }


                    $.ajax({
                        type: "POST",
                        data: {
                            item_id: id
                        },
                        url: setup.urlDelete,
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

                                if(result.message) {
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

                                // sor törlése a DOM-ból
                                oTable.fnDeleteRow(nRow);
                            }

                            if (result.status == 'error') {
                                
                                if (result.message) {
                                    App.alert({
                                        type: 'danger',
                                        //icon: 'warning',
                                        message: result.message,
                                        container: ajax_message,
                                        place: 'append',
                                        close: true, // make alert closable
                                        reset: true, // close all previouse alerts first
                                        //focus: true, // auto scroll to the alert after shown
                                        closeInSeconds: 4 // auto close after defined seconds
                                    });  
                                }

                            }
                        },
                        error: function(xhr, textStatus, errorThrown){
                            console.log(errorThrown);
                            console.log("Hiba történt: " + textStatus);
                            console.log("Rendszerválasz: " + xhr.responseText); 
                        } 
                    });
                }

            });

        });
    }

    /**
     * MÉGSEM gomb megnyomásakor
     */
    var initCancel = function() {

        table.on('click', '.cancel', function (e) {
            e.preventDefault();

            if (nNew) {
                // sor törlése a DOM-ból
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });
    }

    /**
     * Elem szerkesztése
     */
    var initEdit = function() {

        table.on('click', '.edit', function (e) {
            e.preventDefault();

            var reference = $(this);
            /* Get the row as a parent of the link that was clicked on */
            var nRow = reference.parents('tr')[0];

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == '<i class="fa fa-check"></i> Mentés') {
                /* Editing this row and want to save it */
                bootbox.setDefaults({
                    locale: "hu"
                });
                bootbox.confirm("Biztosan menteni akarja a módosítást?", function (result) {
                    if (result) {

                        var ajax_message = $('#ajax_message');

                        // sor id-jének meghatározása
                        var id = reference.closest('tr').attr('data-id');

                        // php feldolgozó url-je (insert, vagy update feldolgozó)
                        var target_url;

                        // a kiválasztott referens id meghatározása
                        var selected_agent_id = $('select.select_agent').val();
                        
                        // Kerület neve a módósítás után
                        var district_name = reference.closest('tr').find('input').val();


                        // INSERT
                        // új elem létrehozásakor még nincs data-id attribútum, ezért az id-nek adunk egy null értéket, ebből a php feldolgozó tuni fogja, hogy insert lekérdezést kell csinálni
                        if (typeof id === 'undefined') {
                            id = null;
                            target_url = setup.urlInsert;
                        // UPDATE    
                        } else {
                            target_url = setup.urlUpdate;
                        }


                        $.ajax({
                            type: "POST",
                            data: {
                                id: id,
                                district_name: district_name,
                                agent_id: selected_agent_id
                            },
                            url: target_url,
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


                                    // ha új sor került a táblázatba (mert van a result objektumnak inserted_id tulajdonsága)
                                    if (result.inserted_id) {
                                        // az új tr elemnek adunk egy data-id attribútumot az új id-vel    
                                        $(nEditing).attr('data-id', result.inserted_id);
                                        
                                        // a táblázatban az egyéb oszlopoknak adunk egy default értéket (ha a setupban be van állítva ilyen)
                                        // bejárjuk a setup objektum anotherCols elemét, hogy alapértéket tudjunk adni a táblázat rublikájának
                                        /*
                                        $.each(setup.anotherCols, function(index, content) {
                                            $(nRow).find(':nth-child(' + (content.column + 1) + ')').text(content.default_value);
                                        });
                                        */
                                        
                                        // $(nRow).find(':nth-child(' + (setup.anotherCols.bejegyzesek_szama + 1) + ')').text('0');
                                    }

                                    // sor mentése
                                    saveRow(oTable, nEditing);
                                    // alapbeállítások visszaállítása
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
                            error: function(xhr, textStatus, errorThrown){
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
 
        /**
         * A lista táblázatot kezeli
         * Másik javascriptből meghívható: DatatableEditable.init(setup)
         *
         * @param objektum setup - tartalmazza a táblázat paramétereit, feldolgozó url-eket, táblázat oszlopainak számát sorrendjét stb. 
         */ 
        init: function (options) {           
            // call local function
            initOptions(options);
            initDataTable();
            initInsert();
            initDelete();
            initCancel();
            initEdit();
        },
 
        deleteAllRows: function(){
            _deleteAllRows(oTable);
        }

    };
}();

$(document).ready(function() {    
	District_list.init();
});