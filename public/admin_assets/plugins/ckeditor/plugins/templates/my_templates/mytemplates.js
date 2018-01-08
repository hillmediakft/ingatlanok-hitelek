/*
 Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/
CKEDITOR.addTemplates("default",
{
	imagesPath:CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates")+"my_templates/images/"),
	
	templates:
		[
			                      
        {
        title:"Szöveg dobozban",
	image:"szoveg_doboz.jpg",
	description:"Szöveg dobozban",
	html: '<div class="well">Nullam tincidunt gravida erat, vel faucibus ligula luctus a.&nbsp;</div>'
        },
        
        {
        title:"Kiemelt szöveg",
	image:"szoveg_kiemelese.jpg",
	description:"Szöveg kiemelése nagyobb méretben",
	html: '<blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p></blockquote>'
        },        

{
        title:"Lista elem",
	image:"lista.jpg",
	description:"Pipával ellátott lista",
	html: '<ul listing style-1><li>Lorem ipsus lures</li><li>Lorem ipsus lures</li><li>Lorem ipsus lures</li><li>Lorem ipsus lures</li><li>Lorem ipsus lures</li><li>Lorem ipsus lures</li></ul>'
        },          

{
        title:"Gomb linkkel",
	image:"gomb_linkkel.jpg",
	description:"Linket tartalmazó további részletek gomb",
	html: '<a class="simple-btn sm-button filled red" href="#">Tovább</a>'
        },          
       
{
        title:"Link",
	image:"arrow_link.jpg",
	description:"Egyszerű link nyíllal",
	html: '<p class="outbound-link><a href="#">További információ <i class="fa fa-arrow-right"></i></a></p>'
        },
{
        title:"Kép középen",
	image:"image-center.jpg",
	description:"Középre rendezett kép",
	html: '<img class="center-block" alt="" src="/public/admin_assets/img/placeholder-400x300.png">'
        }          
		]
});

