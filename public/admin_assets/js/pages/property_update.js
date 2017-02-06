var updateProperty = function () {

    var locationsInput = function () {


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

                    // a kiválasztott város kijelölése az option listában (az lista select elemének data-selected attribútumából)
                    var selected_city = $('#varos_select').attr("data-selected");
                    $("#varos_select option").filter('[value="' + selected_city + '"]').prop("selected", true);
                    $('#varos_select').removeAttr("data-selected");
                }
            });

        }

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
        // a megye id-je
        option_value = $("select#megye_select option:selected").val();
        // ha Budapest (id=5), akkor a kerület lista engedélyezve lesz
        if (option_value == '5') {
            $('#district_select').prop("disabled", false);
        }
        //megye módosítása
        $("#megye_select").change(function () {
            var str = "";
            // a megye id-je
            option_value = $("select#megye_select option:selected").val();

            // ha Budapest (id=5)
            if (option_value == '5') {
                $('#district_select').prop("disabled", false);
            } else {
                $('#district_select').prop("disabled", true);
                $('#district_select option:selected').prop('selected', false);
            }

        })
    };

    var enableEpuletSzintjei = function () {
        $("#emelet").change(function () {
            option_value = $("select#emelet option:selected").val();
            // ha Budapest (id=5), akkor a kerület lista engedélyezve lesz
            if (option_value != '') {
                $('#epulet_szintjei').prop("disabled", false);
            } else {
                $('#epulet_szintjei').prop("disabled", true);
            }
        })
    };

    var setEpuletSzintjei = function () {

        option_value = $("select#emelet option:selected").val();
        // ha Budapest (id=5), akkor a kerület lista engedélyezve lesz
        if (option_value != '') {
            $('#epulet_szintjei').prop("disabled", false);
        } else {
            $('#epulet_szintjei').prop("disabled", true);
        }
    };

    /**
     *	Form adatok UPDATE elküldése gomb
     */
    var send_form_trigger_update = function () {
        $("#data_update_ajax").on("click", function () {
            $('#upload_data_form').submit();
        });
    };

    /**
     *	Feltöltött kép törlése gomb
     */
    var delete_photo_trigger = function () {

        $("#photo_list li button").on("click", function () {
            var li_element = $(this).closest('li');
            var html_id = li_element.attr('id');
            // kivesszük az id elől az elem_ stringet
            $sort_id = html_id.replace(/elem_/, '');

            //console.log(html_id);	
            //console.log('törlendő elem száma: ' + $sort_id);	

            $.ajax({
                url: "admin/property/file_delete",
                type: 'POST',
                dataType: "json",
                data: {
                    id: $('#data_update_ajax').attr('data-id'),
                    sort_id: $sort_id,
                    type: "kepek" //a file_delete php metódusnak mondja meg, hogy képet, vagy doc-ot kell törölni
                },
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
                        //töröljük a dom-ból ezt a lista elemet
                        li_element.remove();

                        //újraindexeljük a listaelemek id-it, hogy a php egyszerűen feldolgozhassa a változtatást
                        $("#photo_list li").each(function (index) {
                            index += 1;
                            $(this).attr('id', 'elem_' + index);
                        });
                    } else {
                        console.log('Kép törlési hiba a szerveren');
                    }
                },
                error: function (result, status, e) {
                    console.log(e);
                }
            });

        });
    };


    /**
     *	Feltöltött dokumentumok törlése gomb
     */
    var delete_doc_trigger = function () {

        $("#dokumentumok li button").on("click", function () {
            var li_element = $(this).closest('li');
            var html_id = li_element.attr('id');
            // kivesszük az id elől az elem_ stringet
            $sort_id = html_id.replace(/doc_/, '');
            //console.log(html_id);	
            console.log('törlendő elem száma: ' + $sort_id);
            $.ajax({
                url: "admin/property/file_delete",
                type: 'POST',
                dataType: "json",
                data: {
                    id: $('#data_update_ajax').attr('data-id'),
                    sort_id: $sort_id,
                    type: "docs" //a file_delete php metódusnak mondja meg, hogy képet, vagy doc-ot kell törölni
                },
                beforeSend: function () {
                    App.blockUI({
                        boxed: true,
                        message: 'Feldolgozás...'
                    });
                },
                complete: function () {
                    console.log('complete');
                    App.unblockUI();
                },
                success: function (result) {
                    if (result.status == 'success') {
                        //töröljük a dom-ból ezt a lista elemet
                        li_element.remove();

                        //újraindexeljük a listaelemek id-it, hogy a php egyszerűen feldolgozhassa a változtatást
                        $("#dokumentumok li").each(function (index) {
                            index += 1;
                            $(this).attr('id', 'doc_' + index);
                        });
                    } else {
                        console.log('Dokumentum törlési hiba a szerveren');
                    }
                },
                error: function (result, status, e) {
                    console.log(e);
                }
            });

        });
    }


    /**
     *	Form validátor
     *	(ha minden rendben indítja a send_data() metódust ami ajax-al küldi az adatokat)
     */
    var handleValidation1 = function () {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#upload_data_form');
        var error1 = $('.alert-danger', form1);
        var error1_span = $('.alert-danger > span', form1);
        //var success1 = $('.alert-success', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: ":disabled", // validate all fields including form hidden input
            rules: {
                ref_id: {
                    required: true,
                },                
                ref_num: {
                    required: true,
                    number: true,
                    max: 9999
                },                
                kategoria: {
                    required: true
                },
                tipus: {
                    required: true
                },
                ar_elado: {
                    required: true,
                    number: true
                },
                ar_kiado: {
                    required: true,
                    number: true
                },
                megye: {
                    required: true
                },
                varos: {
                    required: true
                },
                iranyitoszam: {
                    required: true,
                    number: true
                },
                kerulet: {
                    required: true
                },
                utca: {
                    required: true
                },
                /*
                hazszam: {
                    required: true
                },
                */
                alapterulet: {
                    required: true,
                    number: true
                },
                telek_alapterulet: {
                    number: true
                },
                belmagassag: {
                    number: true
                },                               
                erkely_terulet: {
                    number: true
                },
                terasz_terulet: {
                    number: true
                },
                kozos_koltseg: {
                    number: true
                },
                rezsi: {
                    number: true
                },
                tulaj_email: {
                    email: true
                },
                /*
                tulaj_nev: {
                    required: true
                },
                tulaj_tel: {
                    required: true
                },
                */

            },

            // hiba elem helye, a helyes megjelenés miatt
            errorPlacement: function (error, element) { // render error placement for each input type
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
            },

            // az invalidHandler akkor aktiválódik, ha elküldjük a formot és hiba van
            invalidHandler: function (event, validator) { //display error alert on form submit              
                //success1.hide();
                var errors = validator.numberOfInvalids();
                error1_span.html(errors + ' mezőt nem megfelelően töltött ki!');
                error1.show();
                App.scrollTo(error1, -200);
                error1.delay(4000).fadeOut('slow');

                //console.log(event);	
                //console.log(validator);	
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group                   
                /*	
                 //menü cím színének megvátoztatása
                 var tab_id = $(element).closest('.tab-pane').attr('id');                  
                 $(".nav-tabs li a[href='#" + tab_id + "']").css('color', '#a94442');
                 //$(".nav-tabs li a[href='#" + tab_id + "']").addClass('has-error');
                 */
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group                   
                /*
                 //menü cím színének megvátoztatása
                 var tab_id = $(element).closest('.tab-pane').attr('id');                  
                 $(".nav-tabs li a[href='#" + tab_id + "']").css('color', '');			
                 */


            },
            success: function (label) {
                //label.closest('.form-group').removeClass('has-error').addClass("has-success"); // set success class to the control group
                label.closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function (form) {
                error1.hide();

                //success1.show();
                //success1.delay(4000).fadeOut('slow');

                //adatok elküldése "normál" küldéssel
                //form.submit();

                //form adatok elküldése ajax-al
                // ha a gomb nem disabled
                /*
                 if ($('#data_upload_ajax').prop('disabled') == false) {
                 insert_data();
                 }
                 */
                // ha a gomb nem disabled
                if ($('#data_update_ajax').prop('disabled') == false) {
                    update_data();
                }

            }
        });
    }

    /**
     *	Fájl feltöltése
     *	(kartik-bootstrap-fileinput)
     */
    var handleFileUpload = function () {
        //console.log('load_fileupload');
        $("#input-4").fileinput({
            uploadUrl: "admin/property/file_upload_ajax", // server upload action
            uploadAsync: false,
            uploadExtraData: {id: $('#data_update_ajax').attr('data-id')},
            showCaption: false,
            showUpload: true,
            language: "hu",
            maxFileCount: 10,
            maxFileSize: 3000,
            allowedFileExtensions: ["jpg", "jpeg", "gif", "png", "bmp"],
            allowedPreviewTypes: ['image'],
            dropZoneEnabled: false
                    //previewSettings: {image: {width: "auto", height: "90px"}},
                    //dropZoneTitle: '',
                    //showPreview: false,
                    //showUploadedThumbs: true
                    //allowedFileTypes: ["image", "video"]
        });

        $("#input-4").on('fileloaded', function (event, file, previewId, index, reader) {
            //console.log("fileloaded");
            $('.kv-file-upload').hide();
        });
        /*
         
         $("#input-4").on('fileimageloaded', function(event, previewId) {
         console.log("fileimageloaded");
         
         });
         
         $("#input-4").on('filebatchuploadsuccess', function(event, data, previewId, index) {
         //var form = data.form; var files = data.files; var extra = data.extra; var response = data.response; var reader = data.reader;
         console.log('File batch upload success');
         });	
         $("#input-4").on('fileuploaded', function(event, data, previewId, index) {
         $('.file-preview-success').remove();
         });
         */

        $("#input-4").on('filebatchuploadsuccess', function (event, data, previewId, index) {

            var form2 = $('#upload_files_form');
            var success2 = $('.alert-success', form2);
            var success2_span = $('.alert-success > span', form2);
            var error2 = $('.alert-danger', form2);
            var error2_span = $('.alert-danger > span', form2);
            var sortable_ul = $("#photo_list");

            if (data.response.status == 'success') {
                //console.log('A feltöltés sikeres!');
                success2_span.html('Kép feltöltése sikeres.');
                success2.show();
                success2.delay(3000).fadeOut('fast');

                // képek lekérdezése a listás megjelenítéshez
                $.ajax({
                    url: "admin/property/show_file_list",
                    type: 'POST',
                    //dataType: "json",
                    data: {
                        id: $('#data_update_ajax').attr('data-id'),
                        type: 'kepek'
                    },
                    success: function (result) {
                        // html képek lista
                        sortable_ul.html(result);
                        //újra el kell indítani ezt a metódust
                        delete_photo_trigger();
                    }
                });

            } else {
                //console.log(data.response);
                error2_span.html(data.response[0]);
                error2.show();
                error2.delay(3000).fadeOut('fast');
            }
        });

        $("#input-4").on('filebatchuploadcomplete', function (event, files, extra) {
            //törli a file inputot
            $('#input-4').fileinput('clear');
        });
        /*		
         
         $("#input-4").on('fileclear', function(event) {
         console.log("fileclear");
         });
         
         $("#input-4").on('filecleared', function(event) {
         console.log("filecleared");
         });	
         
         
         $("#input-4").on('filereset', function(event) {
         console.log("filereset");
         });
         */

    }

    /**
     *	Dokumentumok feltöltése
     *	(kartik-bootstrap-fileinput)
     */
    var handleDocUpload = function () {
        //console.log('load_DocUpload');
        $("#input-5").fileinput({
            uploadUrl: "admin/property/doc_upload_ajax", // server upload action
            uploadAsync: false,
            uploadExtraData: {id: $('#data_update_ajax').attr('data-id')},
            showCaption: false,
            showUpload: true,
            language: "hu",
            maxFileCount: 10,
            maxFileSize: 3000,
            allowedFileExtensions: ["jpg", "txt", "pdf", "xps", "csv", "doc", "docx", "xls", "xlsx", "ppt", "pps", "rtf", "ods", "odt", "odp"],
            allowedPreviewTypes: ['image'],
            previewFileIconSettings: {
                'doc': '<i class="fa fa-file-word-o text-primary"></i>',
                'xls': '<i class="fa fa-file-excel-o text-success"></i>',
                'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
                'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
                'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
            },
            previewFileExtSettings: {
                'doc': function (ext) {
                    return ext.match(/(doc|docx)$/i);
                },
                'xls': function (ext) {
                    return ext.match(/(xls|xlsx|csv)$/i);
                },
                'ppt': function (ext) {
                    return ext.match(/(ppt|pptx)$/i);
                }
            },
            dropZoneEnabled: false
                    //showPreview: false,
                    //allowedPreviewTypes: ['image'],
                    //dropZoneTitle: '',
                    //showUploadedThumbs: true
                    //allowedFileTypes: ["image", "video"],
        });

        $("#input-5").on('fileloaded', function (event, file, previewId, index, reader) {
            //console.log("fileloaded");
            $('.kv-file-upload').hide();
        });

        $("#input-5").on('filebatchuploadsuccess', function (event, data, previewId, index) {

            var form2 = $('#upload_files_form');
            var success2 = $('.alert-success', form2);
            var success2_span = $('.alert-success > span', form2);
            var error2 = $('.alert-danger', form2);
            var error2_span = $('.alert-danger > span', form2);
            var $dokumentumok = $("#dokumentumok");

            if (data.response.status == 'success') {
                //console.log('A feltöltés sikeres!');
                success2_span.html('File feltöltése sikeres.');
                success2.show();
                success2.delay(3000).fadeOut('fast');

                // dokumentumok lekérdezése a listás megjelenítéshez
                $.ajax({
                    url: "admin/property/show_file_list",
                    type: 'POST',
                    //dataType: "json",
                    data: {
                        id: $('#data_update_ajax').attr('data-id'),
                        type: 'docs'
                    },
                    success: function (result) {
                        // html képek lista
                        $dokumentumok.html(result);
                        //újra el kell indítani ezt a metódust
                        delete_doc_trigger();
                    }
                });

            } else {
                console.log(data.response);
                error2_span.html(data.response[0]);
                error2.show();
                error2.delay(3000).fadeOut('fast');
            }
        });

        $("#input-5").on('filebatchuploadcomplete', function (event, files, extra) {
            //törli a file inputot
            $("#input-5").fileinput('clear');
        });
    }

    /**
     *	Feltöltött képek sorrendjének módosítása
     *	Egy elem helyének módosítása után elküldi a kiszolgálónak a módosított sorrendet
     *	A kiszólgálón módosul a sorrend, és a pozitív válasz után...
     *	a javascript a megváltoztatott sorrendű html lista elemek id-it "visszaindexeli" - 1,2,3,4 ... sorrendbe
     */
    var itemOrder = function () {
        $("#photo_list").sortable({
            items: "li",
            distance: 10,
            cursor: "move",
            axis: "y",
            revert: true,
            opacity: 0.7,
            tolerance: "pointer",
            containment: "parent",
            update: function (event, ui) {
                // a sorok id-it felhasználva képez egy tömböt (id_neve[]=2&id_neve[]=1&id_neve[]=3&id_neve[]=4)
                var $sort_str = $(this).sortable("serialize");
                //console.log($sort_str);
                $.ajax({
                    url: "admin/property/photo_sort",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        id: $('#data_update_ajax').attr('data-id'),
                        sort: $sort_str
                    },
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
                            //console.log('sorbarendezés sikeres');
                            //újraindexeljük a listaelemek id-it, hogy a php egyszerűen feldolgozhassa a változtatást
                            $("#photo_list li").each(function (index) {
                                index += 1;
                                $(this).attr('id', 'elem_' + index);
                            });
                        } else {
                            console.log('sorbarendezési hiba a szerveren');
                        }
                    }
                });

            }
        });

    }

    /*
     * CKeditor inicializálása
     */
    var ckeditorInit = function () {
        CKEDITOR.replace('leiras_hu', {customConfig: 'config_minimal1.js'});
        CKEDITOR.replace('leiras_en', {customConfig: 'config_minimal1.js'});
    };

    /**
     *	Frissíti a CKeditor-t
     *	(enélkül nem küldi el a ckeditorba írt adatokat)
     */
    var CKupdate = function () {
        for (instance in CKEDITOR.instances)
            CKEDITOR.instances[instance].updateElement();
    }

    /**
     *	UPDATE-eli az adatbázisban az ingatlan adatokat
     *	Eltünteti az "insert" gombot, és megjeleníti az "update" gombot
     *	Engedélyezi és elérhetővé teszi a file feltöltést
     */
    var update_data = function () {
        //utca nevének küldése a php-nak rejtett inputmezőben (az irányítószám és házszám nélkül)
        var orig_utca_nev = $("#utca_select option:selected").html();
        console.log(orig_utca_nev);
        //megvizsgáljuk, hogy az utca listából kiválasztottak-e valamit, mert ha nem akkor az orig_utca_nev értéke "undefined" lesz (ha undefined, akkor a replace-t nem lehet végrehajtani és hibaüzentet ad a console-ban)
        if (typeof orig_utca_nev != 'undefined') {
            var utca_nev_temp = orig_utca_nev.replace(/\s\([0-9]+\)/, ''); //leszedük az irányítószámot
            var utca_nev = utca_nev_temp.replace(/\s([0-9]+)\-([0-9]+)\./, ''); //leszedük feleleges házszámot pl.: 1-23.
            $("#utca_nev").val(utca_nev); //berakjuk a rejtett input-ba
        }

        CKupdate(); //CKeditor tartalmának frissítése

        // last insert id a #data_update_ajax button data-id attribútumában van
        var $id = $('#data_update_ajax').attr('data-id');
        //console.log('ez az utolsó id: ' + $id);
        var $data = $('#upload_data_form').serialize();
        // hozzáfűzzük a form adataihoz a last insert id-t (az update_id kulcsal) és...
        // hozzáadunk egy update_status adatot is, hogy el tudja dönteni a php, hogy adatbevitel utáni, vagy "rendes" update-et hajtunk-e végre (ez a módosítás dátum miatt kell)
        $data = $data + "&update_id=" + $id + "&update_status=1";

        $.ajax({
            url: "admin/property/insert_update",
            data: $data,
            type: "POST",
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
                //console.log(result);

                if (result.status == 'success') {
                    //console.log('adatok módosítva az adatbázisban');

                    var $host = window.location.host;
                    window.location.href = "http://" + $host + "/admin/property";

                    // üzenet doboz megjelenítése
                    /*
                     var form = $('#upload_data_form');
                     var success = $('.alert-success', form);
                     var success_text = $('.alert-success > span', form);
                     success_text.html('Az adatok módosultak az adatbázisban.');
                     success.show();
                     success.delay(3000).fadeOut('slow');
                     */

                } else {
                    // üzenet doboz megjelenítése
                    var form1 = $('#upload_data_form');
                    var error = $('.alert-danger', form1);
                    var error_span = $('.alert-danger > span', form1);
                    error_span.html('');

                    // result tömb (hibaüzenetek) bejárása
                    $.each(result.error_messages, function (index, value) {
                        //console.log(index + ' : ' + value);
                        error_span.append(value + "<br />");
                    });

                    error.show();
                    error.delay(10000).fadeOut('slow');
                    console.log('Hiba az adatok adatbáziba írásakor!');
                }
            },
            error: function (result, status, e) {
                alert(e);
            }
        });
    }

    var enableDisablePrices = function () {

        // option listaelem value
        option_value = $("select#tipus option:selected").val();
        // az érték üres lesz, ha a válassz elemet választjuk ki az option listából
        if (option_value == '1') {
            $('#ar_elado').prop("disabled", false);
            $('#ar_kiado').prop("disabled", true);

        }
        if (option_value == '2') {
            $('#ar_elado').prop("disabled", true);
            $('#ar_kiado').prop("disabled", false);

        }

        //típus kiválasztása szerint engedélyezi / blokkolja az ár beviteli mezőket
        $("#tipus").change(function () {
            // option listaelem value
            option_value = $("select#tipus option:selected").val();
            // az érték üres lesz, ha a válassz elemet választjuk ki az option listából
            if (option_value == '1') {
                $('#ar_elado').prop("disabled", false);
                $('#ar_kiado').prop("disabled", true);

            }
            if (option_value == '2') {
                $('#ar_elado').prop("disabled", true);
                $('#ar_kiado').prop("disabled", false);

            }

        })
    }

    var mapGeocoding = function () {

        var map = new GMaps({
            div: '#gmap_geocoding',
            lat: 47.50,
            lng: 19.04
        });
        varos = $('#varos_select option:selected').text();
        utca = $('#utca_autocomplete').val();
        iranyitoszam = $('#iranyitoszam').val();
        hazszam = $('#hazszam').val();

        var text = iranyitoszam + ' ' + varos + ', ' + utca + ' ' + hazszam;

        GMaps.geocode({
            address: text,
            callback: function (results, status) {
                if (status == 'OK' && results[0].formatted_address != '') {

                    $('#address_message').html('<div class="note note-info note-bordered">' + results[0].formatted_address + '</div>');

                    var latlng = results[0].geometry.location;
                    map.setCenter(latlng.lat(), latlng.lng());
                    map.addMarker({
                        lat: latlng.lat(),
                        lng: latlng.lng()
                    });
                    App.scrollTo($('#gmap_geocoding'));

                } else {
                    $('#address_message').html('<div class="note note-danger note-bordered">Nem állapítható meg cím! Ellenőrizza a cím adatokat!</div>');
                }
            }
        });
    }

    var showMap = function () {
        $('#show_map').click(function (e) {
            e.preventDefault();
            mapGeocoding();
        });
    }

    var streetAutocomplete = function () {
        $('#utca_autocomplete').autocomplete({
            serviceUrl: 'admin/property/street_list',
            onSelect: function (suggestion) {
            }
        });
    };

    var checkErkely = function () {

        $('#erkely').change(function () {
            if ($(this).is(":checked")) {
                $('#erkely_terulet').prop("disabled", false);
            } else {
                $('#erkely_terulet').prop("disabled", true);
                $('#erkely_terulet').val("");
            }
        });
    };

    var checkTerasz = function () {

        $('#terasz').change(function () {
            if ($(this).is(":checked")) {
                $('#terasz_terulet').prop("disabled", false);
            } else {
                $('#terasz_terulet').prop("disabled", true);
                $('#terasz_terulet').val("");
            }
        });
    };

    var arcsokkentes = function () {
        // az új ár beviteli mezők és e-mail küldés checkbox elrejtése
        $('#arvaltozas').hide();
        $('#email_kuldes_arvaltozasrol').hide();
        // az árváltozás aktiválása gombra kattintás után az új ár beviteli mező és e-mail küldés checkbox megjelenítése
        $('#arvaltozas_aktivalas').click(function () {
            $('#arvaltozas').fadeIn('slow');
            $('#email_kuldes_arvaltozasrol').fadeIn('slow');
        })
        // az új ár beírása után az email küldés checkbox módosítása
        // ha í beírt érték nem nulla, akkor pipa, egyébként pipa eltávolítása
        $("input[name=ar_elado_uj]").change(function () {
            if ($("input[name=ar_elado_uj]").val() != '0') {
                $('input[name=email_kuldes_arvaltozasrol]').prop('checked', true).uniform();
            } else {
                $('input[name=email_kuldes_arvaltozasrol]').prop('checked', false).uniform();
            }
        })
        // az árváltozás deaktiválása gombra kattintás után az új ár beviteli mező és e-mail küldés checkbox eltüntetése, új ar_elado_uj mező értékének 0-ra //          // állítása
        $('#arvaltozas_deaktivalas').click(function () {
            $('input[name=email_kuldes_arvaltozasrol]').prop('checked', false).uniform();
            $('#email_kuldes_arvaltozasrol').fadeOut();
            $("input[name=ar_elado_uj]").val('0');
            $('#arvaltozas').fadeOut('slow');
        })
    };

    return {
        //main function to initiate the module
        init: function () {
            //hideAlert();
            //handleDatePickers();
            locationsInput();
            handleValidation1();
            itemOrder();
            send_form_trigger_update();
            delete_photo_trigger();
            delete_doc_trigger();
            handleFileUpload();
            handleDocUpload();
            enableDisablePrices();
            enableDistrict();
            enableEpuletSzintjei();
            setEpuletSzintjei();
            ckeditorInit();
            showMap();
            streetAutocomplete();
            checkErkely();
            checkTerasz();
            arcsokkentes();
        }
    };

}();

jQuery(document).ready(function () {
    updateProperty.init();
});