<?php

/* 
	Plugin Name: Plugin PopupInfo
	Description: Un pluggin perettant d'afficher des popup sur des pages avec des shortcodes
	Versions: 0.0.1
	Author: Fred MAS
 */

//add script
add_action( "wp_enqueue_scripts", "add_popup_info_scripts" );
function add_popup_info_scripts(){

	wp_enqueue_script( "popupInfo_script", plugin_dir_url('./').'popup/assets/popupscripts.js', array( 'jquery' ), true);

	wp_enqueue_style( 'popupStyles', plugin_dir_url( './' )."popup/assets/popupStyles.css" );
}

add_action( "init", "create_popup_post_type" );
function create_popup_post_type(){
	register_post_type( "popup", [
		"label" 			=> "Popup",
		"labels" 			=> [
			"name" 			=> "pupup",
			"singular_name" => "pupup",
			"all_items"		=> "Toutes les pupup",
			"add_new" 		=> "Ajouter popup"
		],
		"description" 		=> "Ajoutez des détails et des définitions courtes. Ajoutez les avec un shortcode",
		"show_in_menu"  	=> true,
		"public" 			=> true,
		"menu_icon"			=> "dashicons-admin-comments",
		"menu_position" 	=> 3,
		"supports" 			=> [
			"title",
			"editor",
			"revisions",
			"thumbnail"
		],
	] );
}

add_shortcode( "popup", "displayShortcode" );
function displayShortcode( $atts ){

	$popup = new WP_Query( [
		"post_type" => "popup"
	] );
	
	if( $popup->have_posts() ){
		while( $popup->have_posts() ){
			$popup->the_post();

			foreach( $atts as $value ){
				
				$title = get_the_title();
				
				if( $value == get_the_title() ){
					
					$content = get_the_content();
					
					$popup_html = '<span class="popup"> ';
					$popup_html .= $title;
					$popup_html .= ' <i class="popup-text">'.$content.'</i>';
					$popup_html .='</span>';
				}
				else {
					$popup_html = ' '.$title.' '; 
				}
			}
		}
	}
	return $popup_html;
}

add_action( "add_meta_boxes", "register_popup" );

function register_popup(){
	add_meta_box( "notes", "Notes", "display_note_field", "avis");
}
