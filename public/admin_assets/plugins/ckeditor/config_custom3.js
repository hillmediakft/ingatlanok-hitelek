/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    config.language = 'hu';
    //config.uiColor = '#AADC6E';

    // szélesség és magasság beállítása
    config.height = 300;
    //config.width = 500;

    //config.templates_files = [ 'public/admin_assets/plugins/ckeditor/my_templates/mytemplates.js' ];
    config.templates_files = ['public/admin_assets/plugins/ckeditor/plugins/templates/my_templates/mytemplates.js?v=20171128-5'];

    //csak a 'kicseréli a jelenlegi tartalmat' checkbox állapotát állítja be
    config.templates_replaceContent = false;

    config.extraPlugins = 'youtube';

    config.toolbar = [
        {name: 'alap_formazas', items: ['Bold', 'Italic', 'Underline', 'RemoveFormat']},
        {name: 'igazitas', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
        {name: 'listak', items: ['BulletedList', 'NumberedList']},
        {name: 'paragraph', items: ['Outdent', 'Indent', 'Blockquote']},
        {name: 'clipboard', items: ['PasteText']},
        {name: 'visszavonas', items: ['Undo', 'Redo']},
        {name: 'linkek', items: ['Link', 'Unlink']},
        {name: 'tools', items: ['Image', 'Youtube', 'Table', 'HorizontalRule']},
        {name: 'formazas', items: ['SpecialChar', 'Styles', 'Format']},
        {name: 'document', items: ['Source']},
        {name: 'templates', items: ['Templates']}
    ];

// true: nem távolítja el a html, head és body tag-eket, false nem rak be html, head és body tag-eket
    config.fullPage = false;

// szöveg bemásolásakor csak paraagrafusok és linkek maradnak meg
    config.pasteFilter = 'p; a[!href]';
    // Gombok eltávolítása az eszköztárból
    //config.removeButtons = 'Underline,Subscript,Superscript,Templates';
    config.removeButtons = 'Underline,Subscript,Superscript';
    // Youtube plug-in beépítése
//	config.extraPlugins = 'youtube';
    // minden html elem engedélyezése (nem távolít el semmit)
    config.allowedContent = true;
    // Az ékezetes és speciális karaktereket nem alakítja át html entity-vé
    config.htmlEncodeOutput = false;
    config.entities = false;
    config.basicEntities = false;
    // szövegeket, img tageket nem csomagol automatikusan <p> tagekbe
    config.autoParagraph = false;
    // engedélyezi az üres tageket
    config.fillEmptyBlocks = false;
    // nem távolítja el a <i ... </i> közé zárt tartalmat - font ikon megjelenítés
    config.protectedSource.push(/<i[^>]*><\/i>/g);
    // nem jeleníti meg egyáltalán a {} közötti tartalmat pl.: {$slider}
	config.protectedSource.push(/{[\s\S]*?}/g); 
    // nem távolítja el az üres span tag-eket
    CKEDITOR.dtd.$removeEmpty['span'] = false;
    CKEDITOR.dtd.$removeEmpty['p'] = true;

    config.contentsCss = ['/public/site_assets/css/bootstrap.min.css', '/public/site_assets/css/main-red.css', '/public/admin_assets/plugins/ckeditor/no-background.css'];

    //enterre <br> taget rak be nem <p> taget
   // config.enterMode = CKEDITOR.ENTER_BR;

    //kcfinder		
    config.filebrowserBrowseUrl = 'public/admin_assets/plugins/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl = 'public/admin_assets/plugins/kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl = 'public/admin_assets/plugins/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl = 'public/admin_assets/plugins/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl = 'public/admin_assets/plugins/kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl = 'public/admin_assets/plugins/kcfinder/upload.php?type=flash';

};