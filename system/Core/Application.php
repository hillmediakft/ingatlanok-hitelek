<?php
namespace System\Core;

use System\Libs\DI;
use System\Libs\Message;
use System\Libs\Language;
use System\Libs\Auth;
use System\Libs\EventManager;
use System\Libs\Config;

class Application {

    protected $request;

    public function __construct() {
        // request objektum visszaadása (itt már létrejön az uri és router objektum is!)
        $this->request = DI::get('request');

        // area állandó létrehozása
        define('AREA', $this->request->get_uri('area'));
        define('LANG', $this->request->get_uri('langcode'));
        // Betöltjük az aktuális nyelvnek megfelelő üzenet fájlt
        Message::init('messages_' . AREA, $this->request->get_uri('langcode'));

        if (AREA == 'site' && MULTILANG_SITE == true) {
            // nyelvi fájl betöltése
            Language::init(LANG, DI::get('connect'));
            // egyeb fordítások
            Config::load('translations');
        }
        // Megadjuk az Auth osztály alapbeállításait ('auth.php' config file betöltése)
        Auth::init('auth');

        // események inicializálása
        EventManager::init('events');

        // route-ok megadása, controller file betöltése és a megfelelő action behívása
        $this->_loadController();
    }

    private function _loadController() {
        $router = DI::get('router');

        /*         * ************************************************** */
        /*         * ************* SITE ******************************* */
        /*         * ************************************************** */
        if (AREA == 'site') {

            $router->get('/', 'home@index');
            $router->get('/ingatlanok', 'ingatlanok@index');
            $router->get('/ingatlanok/adatlap/:id/:title', 'ingatlanok@adatlap');
            $router->get('/ingatlanok/ertekesito/:title/:id', 'ingatlanok@ertekesito', array('title', 'id'));
            $router->get('/ingatlan-ertekesitoink', 'ingatlanErtekesitoink@index');
            $router->get('/rolunk', 'rolunk@index');
            $router->get('/kapcsolat', 'kapcsolat@index');
            $router->get('/hitel', 'hitel@index');
            $router->get('/allas', 'allas@index');
            $router->get('/hirek', 'hirek@index');
            $router->get('/hirek/kategoria/:id', 'hirek@kategoria', array('id'));
            $router->get('/hirek/:title/:id', 'hirek@reszletek', array('title', 'id'));
            $router->get('/kereses', 'kereses@index');

            $router->get('/profil', 'Profile@index');
            $router->post('/profile/deletefollowed', 'Profile@deleteFollowed'); // ajax
            $router->post('/profile/change_userdata', 'Profile@changeUserdata'); // ajax
            $router->post('/profile/change_password', 'Profile@changePassword'); // ajax
            $router->post('/profile/deletesavedsearch', 'Profile@deleteSavedSearch'); // ajax                

            $router->get('/kedvencek', 'kedvencek@index');
            $router->post('/kedvencek/add_property_to_cookie', 'kedvencek@add_property_to_cookie'); // ajax
            $router->post('/kedvencek/delete_property_from_cookie', 'kedvencek@delete_property_from_cookie'); // ajax
            $router->post('/ajaxrequest/kedvencek', 'AjaxRequest@kedvencek');
            
            $router->post('/ingatlanok/arvaltozasertesites', 'ingatlanok@arvaltozasErtesites'); // ajax
			
			$router->post('/getphonenumber', 'GetPhoneNumber@index'); // ajax

            $router->post('/user/login', 'user@login'); // ajax
            $router->get('/felhasznalo/kijelentkezes', 'user@logout');
            $router->post('/user/register', 'user@register'); // ajax
            $router->post('/user/forgottpw', 'user@forgottpw'); // ajax
            $router->get('/felhasznalo/ellenorzes/:id/:hash', 'user@verify', array('id', 'activation_hash')); // ajax
            
            $router->post('/sendemail/init/:title', 'SendEmail@init', array('type'));
            
        // landing page    
        $router->get('/marketing/:title', 'LandingPage@index', array('title'));

            //mennyit-er-az-ingatlanom
            $router->get('/mennyit-er-az-ingatlanom', 'MennyitErAzIngatlanom@index');
            // befektetoknek
            $router->get('/befektetoknek', 'Befektetoknek@index');
            // berbeadoknak
            $router->get('/berbeadoknak', 'Berbeadoknak@index');
            // keresés elmentése - AJAX
            $router->post('/kereses/savesearch', 'Kereses@saveSearch');
            $router->post('/adatlap/:id', 'Adatlap@index');

            $router->set404('error@index');




            $router->mount('/en', function() use ($router) {
                $router->get('/', 'home@index');
                $router->get('/real-estates', 'ingatlanok@index');
                $router->get('/real-estates/data-sheet/:id/:title', 'ingatlanok@adatlap');                
                $router->get('/real-estates/agent/:title/:id', 'ingatlanok@ertekesito');                
                $router->get('/agents', 'ingatlanErtekesitoink@index');
                $router->get('/about-us', 'rolunk@index');
                $router->get('/contact', 'kapcsolat@index');
                $router->get('/credit', 'hitel@index');
                $router->get('/jobs', 'allas@index');
                $router->get('/news', 'hirek@index');
                $router->get('/news/category/:id', 'hirek@kategoria', array('id'));
                $router->get('/news/:title/:id', 'hirek@reszletek', array('title', 'id'));
                $router->get('/search', 'kereses@index');
                
                $router->get('/profile', 'Profile@index');
                $router->post('/profile/deletefollowed', 'Profile@deleteFollowed'); // ajax
                $router->post('/profile/change_userdata', 'Profile@changeUserdata'); // ajax
                $router->post('/profile/change_password', 'Profile@changePassword'); // ajax                
                $router->post('/profile/deletesavedsearch', 'Profile@deleteSavedSearch'); // ajax                
                    
                $router->get('/favourites', 'kedvencek@index');
                $router->post('/kedvencek/add_property_to_cookie', 'kedvencek@add_property_to_cookie'); // ajax
                $router->post('/kedvencek/delete_property_from_cookie', 'kedvencek@delete_property_from_cookie'); // ajax
                $router->post('/ajaxrequest/kedvencek', 'AjaxRequest@kedvencek'); // ajax
                
                $router->post('/ingatlanok/arvaltozasertesites', 'Ingatlanok@arvaltozasErtesites'); // ajax

                $router->get('/user/logout', 'user@logout');
                $router->post('/user/login', 'user@login'); // ajax
                $router->post('/user/register', 'user@register'); // ajax
                $router->post('/user/forgottpw', 'user@forgottpw'); // ajax
                $router->get('/felhasznalo/ellenorzes/:id/:hash', 'user@verify', array('id', 'activation_hash')); // ajax

                $router->post('/sendemail/init/:title', 'SendEmail@init', array('type')); //ajax

            // landing page    
            $router->get('/marketing/:title', 'LandingPage@index', array('title'));

                //mennyit-er-az-ingatlanom
                $router->get('/my-property-is-worth', 'MennyitErAzIngatlanom@index');
                // befektetoknek
                $router->get('/investors', 'Befektetoknek@index');
                // berbeadoknak
                $router->get('/boat-owners', 'Berbeadoknak@index');
                // keresés elmentése - AJAX
                $router->post('/kereses/savesearch', 'Kereses@saveSearch');


            });

            
        }
        /*         * ************************************************** */
        /*         * **************** ADMIN *************************** */
        /*         * ************************************************** */ elseif (AREA == 'admin') {

            $router->mount('/admin', function() use ($router) {

                $router->before('GET|POST', '/?((?!login).)*', function() {
                    if (!Auth::check()) {
                        $response = DI::get('response');
                        $response->redirect('admin/login');
                    }
                });


                $router->get('/', 'home@index');
                $router->get('/home', 'home@index');

                // login logout	
                $router->match('GET|POST', '/login', 'login@index');
                $router->get('/login/logout', 'login@logout');

                // pages	
                $router->get('/pages', 'pages@index');
                $router->match('GET|POST', '/pages/update/:id', 'pages@update', array('id'));

                // content	
                //$router->get('/content', 'content@index');
                //$router->match('GET|POST', '/content/edit/:id', 'content@edit', array('id'));

                // user	
                $router->get('/user', 'user@index');
                $router->match('GET|POST', '/user/insert', 'user@insert');
                $router->match('GET|POST', '/user/profile/:id', 'user@profile', array('id'));
                $router->post('/user/delete', 'user@delete');
                $router->post('/user/change_status', 'user@change_status');
                $router->post('/user/user_img_upload/(upload)', 'user@user_img_upload', array('upload'));
                $router->post('/user/user_img_upload/(crop)', 'user@user_img_upload', array('crop'));
                $router->match('GET|POST', '/user/user_roles', 'user@user_roles');
                $router->match('GET|POST', '/user/edit_roles/:id', 'user@edit_roles', array('id'));

                // photo gallery	
                $router->get('/photo-gallery', 'photo_gallery@index');
                $router->post('/photo-gallery/delete_photo', 'photo_gallery@delete_photo');
                $router->post('/photo-gallery/delete_category', 'photo_gallery@delete_category');
                $router->match('GET|POST', '/photo-gallery/insert', 'photo_gallery@insert');
                $router->match('GET|POST', '/photo-gallery/update/:id', 'photo_gallery@update', array('id'));
                $router->get('/photo-gallery/category', 'photo_gallery@category');

                // slider	
                $router->get('/slider', 'slider@index');
                $router->post('/slider/delete', 'slider@delete');
                $router->match('GET|POST', '/slider/insert', 'slider@insert');
                $router->match('GET|POST', '/slider/update/:id', 'slider@update', array('id'));
                $router->post('/slider/order', 'slider@order');

                // testimonials	
                $router->get('/testimonials', 'testimonials@index');
                $router->match('GET|POST', '/testimonials/insert', 'testimonials@insert');
                $router->match('GET|POST', '/testimonials/update/:id', 'testimonials@update', array('id'));
                $router->get('/testimonials/delete/:id', 'testimonials@delete', array('id'));

                // clients	
                $router->get('/clients', 'clients@index');
                $router->post('/clients/client_img_upload/(upload)', 'clients@client_img_upload', array('upload'));
                $router->post('/clients/client_img_upload/(crop)', 'clients@client_img_upload', array('crop'));
                $router->post('/clients/delete', 'clients@delete');
                $router->match('GET|POST', '/clients/insert', 'clients@insert');
                $router->match('GET|POST', '/clients/update/:id', 'clients@update', array('id'));
                $router->post('/clients/order', 'clients@order');

                // file manager	
                $router->get('/filemanager', 'FileManager@index');

                // settings	
                $router->match('GET|POST', '/settings', 'settings@index');

                // user manual	
                $router->get('/user-manual', 'UserManual@index');

                // translations	
                $router->get('/translations', 'translations@index');
                $router->post('/translations/save', 'translations@save');

                // newsletter	
                $router->get('/newsletter', 'newsletter@index');
                $router->get('/newsletter/newsletter_stats', 'newsletter@newsletter_stats');
                $router->post('/newsletter/delete', 'newsletter@delete');
                $router->match('GET|POST', '/newsletter/insert', 'newsletter@insert');
                $router->match('GET|POST', '/newsletter/update/:id', 'newsletter@update', array('id'));

                // blog	
                $router->get('/blog', 'blog@index');
                $router->post('/blog/delete', 'blog@delete');
                $router->match('GET|POST', '/blog/insert', 'blog@insert');
                $router->match('GET|POST', '/blog/update/:id', 'blog@update', array('id'));
                $router->get('/blog/category', 'blog@category');
                $router->post('/blog/category_insert_update', 'blog@category_insert_update');
                $router->post('/blog/category_delete', 'blog@category_delete');
                $router->post('/blog/change_status', 'blog@change_status');

                //datatables
                $router->get('/datatables/ingatlan_kategoria', 'datatables@ingatlan_kategoria');
                $router->get('/datatables/ingatlan_allapot', 'datatables@ingatlan_allapot');
                $router->get('/datatables/ingatlan_futes', 'datatables@ingatlan_futes');
                $router->get('/datatables/ingatlan_energetika', 'datatables@ingatlan_energetika');
                $router->get('/datatables/ingatlan_kert', 'datatables@ingatlan_kert');
                $router->get('/datatables/ingatlan_kilatas', 'datatables@ingatlan_kilatas');
                $router->get('/datatables/ingatlan_parkolas', 'datatables@ingatlan_parkolas');
                $router->get('/datatables/ingatlan_szerkezet', 'datatables@ingatlan_szerkezet');
                //$router->get('/datatables/ingatlan_komfort', 'datatables@ingatlan_komfort');
                $router->get('/datatables/ingatlan_haz_allapot_kivul', 'datatables@ingatlan_haz_allapot_kivul');
                $router->get('/datatables/ingatlan_haz_allapot_belul', 'datatables@ingatlan_haz_allapot_belul');
                $router->get('/datatables/ingatlan_furdo_wc', 'datatables@ingatlan_furdo_wc');
                $router->get('/datatables/ingatlan_fenyviszony', 'datatables@ingatlan_fenyviszony');
                $router->get('/datatables/ingatlan_emelet', 'datatables@ingatlan_emelet');
                $router->get('/datatables/ingatlan_szoba_elrendezes', 'datatables@ingatlan_szoba_elrendezes');
                $router->post('/datatables/ajax_delete', 'datatables@ajax_delete');
                $router->post('/datatables/ajax_update_insert', 'datatables@ajax_update_insert');

                //documents
                $router->get('/documents', 'documents@index');
                $router->match('GET|POST', '/documents/insert', 'documents@insert');
                $router->match('GET|POST', '/documents/update/:id', 'documents@update', array('id'));
                $router->post('/documents/delete_document_AJAX', 'documents@delete_document_AJAX');
                $router->post('/documents/insert_update_data_ajax', 'documents@insert_update_data_ajax');
                $router->get('/documents/category', 'documents@category');
                $router->post('/documents/category_insert_update', 'documents@category_insert_update');
                $router->post('/documents/category_delete', 'documents@category_delete');
                $router->post('/documents/show_file_list', 'documents@show_file_list');
                $router->post('/documents/doc_upload_ajax', 'documents@doc_upload_ajax');
                $router->post('/documents/file_delete', 'documents@file_delete');
                $router->get('/documents/download/:filename', 'documents@download', array('file'));

                // ingatlanok
                $router->get('/property', 'property@index');
                $router->get('/property/insert', 'property@insert');
                $router->get('/property/update/:id', 'property@update', array('id'));
                $router->get('/property/details/:id', 'property@details', array('id'));
                $router->post('/property/getpropertylist', 'property@getPropertyList');
                
                    // nem végleges törlés
                    $router->post('/property/softdelete', 'property@softdelete');
                    // végleges törlés
                    $router->post('/property/delete', 'property@delete');
                    // törölt elemek oldal
                    $router->get('/property/deleted_records', 'property@deleted_records');
                    // soft deleted rekordok "visszaállítása" 
                    $router->post('/property/cancel_delete', 'property@cancel_delete');
                
                $router->post('/property/county_city_list', 'property@county_city_list');
                $router->post('/property/kerulet_utca_list', 'property@kerulet_utca_list');
                $router->post('/property/insert_update', 'property@insert_update');
                $router->get('/property/street_list', 'property@street_list');
                $router->post('/property/file_upload_ajax', 'property@file_upload_ajax');
                $router->post('/property/doc_upload_ajax', 'property@doc_upload_ajax');
                $router->post('/property/show_file_list', 'property@show_file_list');
                $router->post('/property/file_delete', 'property@file_delete');
                $router->post('/property/change_kiemeles', 'property@change_kiemeles');
                $router->post('/property/change_status', 'property@change_status');
                $router->post('/property/photo_sort', 'property@photo_sort');
                $router->post('/property/cloning', 'property@cloning');
                $router->post('/property/sendemail', 'property@sendEmail'); //ajax

                $router->get('/property/download/:filename', 'property@download', array('file'));

            // landing page    
            $router->get('/landingpage', 'LandingPage@index');
            $router->match('GET|POST', '/landingpage/insert', 'LandingPage@insert');
            $router->match('GET|POST', '/landingpage/update/:id', 'LandingPage@update');

                $router->post('/user/deleteimage', 'User@deleteImage');
                

                $router->get('/pop_up_windows', 'Pop_up_windows@index');
                $router->match('GET|POST', '/pop_up_windows/insert', 'Pop_up_windows@insert');
                $router->match('GET|POST', '/pop_up_windows/update/:id', 'Pop_up_windows@update');
                $router->get('/pop_up_windows/delete/:id', 'Pop_up_windows@delete');
                
                // log lista oldal
                $router->get('/logs', 'Logs@index');

                // ingatlan csv export	
                $router->get('/report/property', 'report@property');

                // pdf generálás
                $router->post('/adatlap/:id', 'Adatlap@index');

                // error	
                $router->set404('error@index');
            });
        }

        // dispatcher objektum példányosítása
        $dispatcher = new \System\Libs\Dispatcher();
        // controller névtérének beállítása
        $dispatcher->setControllerNamespace('System\\' . ucfirst(AREA) . '\Controller\\');

        // before útvonalak bejárása, a megadott elemek futtatása
        $before_callbacks = $router->runBefore();
        $dispatcher->dispatch($before_callbacks);

        // útvonalak bejárása, controller példányosítása, action indítása
        $callback = $router->run();
        $dispatcher->dispatch($callback);
    }

}

// osztály vége
?>