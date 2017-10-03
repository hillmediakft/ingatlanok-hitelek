/**
 Logs oldal
 **/
var Ajanlasok = function () {

    var ajanlasokTable = function () {

        var table = $('#ajanlasok');
        table.dataTable({

            "language": {
                // metronic specific
                //"metronicGroupActions": "_TOTAL_ sor kiválasztva: ",
                //"metronicAjaxRequestGeneralError": "A kérés nem hajtható végre, ellenőrizze az internet kapcsolatot!",
                // data tables specific                
                "decimal": "",
                "emptyTable": "Nincs megjeleníthető adat!",
                "info": "_START_ - _END_ elem &nbsp; _TOTAL_ elemből",
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
            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            // "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            "lengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, "Összes"] // change per page values here
            ],
            // set the initial value
            "pageLength": 20,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {'orderable': true, 'searchable': true, 'targets': 0}, //dátum
                {'orderable': true, 'searchable': true, 'targets': 1}, //név
                {'orderable': true, 'searchable': true, 'targets': 2}, //email
                {'orderable': true, 'searchable': true, 'targets': 3}, //referens
                {'orderable': false, 'searchable': false, 'targets': 4} //megnéz
            ],
            "order": [
                [0, "desc"]
            ] // set column as a default sort by asc
        });
    };


    /**
     * Egy elem klónozása ajax-al confirm
     */
    var showDetails = function () {
        $('[id*="show_modal"]').on('click', function (e) {
            e.preventDefault();

            //var name = $(this).closest("tr").find('td:nth-child(3)').text();
            var id = $(this).attr('data-id'); // a klónozandó elem id-je
            $.ajax({
                type: "post",
                url: "admin/ajanlasok/showAjanlas",
                data: "id=" + id,
                success: function (data) {
                     var name = '<tr><td colspan="4"><strong>Név</strong>: ' + data.name + '</td></tr>';
                    var email = '<tr><td colspan="4"><strong>E-mail:</strong> ' + data.email + '</td></tr>';
                    $('#ajanlas_modal').modal('show');
                    $('#ajanlas_modal_content').html('<table id="ajanlasok_modal_print" class="table"><tbody>' + name + email + data.html_data + '</tbody></table>');
                }
            });
        });
    };


    return {

        //main function to initiate the module
        init: function () {
            /*
             if (!jQuery().dataTable) {
             return;
             }
             */

            ajanlasokTable();
            vframework.printTable({
                print_button_id: "print_ajanlasok", // elem id-je, amivel elindítjuk a nyomtatást 
                table_id: "ajanlasok",
                title: "Elküldött ingatlan ajánlások"
            });
            vframework.printTable({
                print_button_id: "print_ajanlasok_modal", // elem id-je, amivel elindítjuk a nyomtatást 
                table_id: "ajanlasok_modal_print",
                title: "Elküldött ingatlan ajánlások"
            });
            vframework.hideAlert();
            showDetails();
        }

    };
}();
$(document).ready(function () {
    Ajanlasok.init(); // init ajanlasok page
});