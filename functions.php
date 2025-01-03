<?php

// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );

// Classes
require_once 'classes/class-fl-child-theme.php';

// Actions
add_action( 'wp_enqueue_scripts', 'FLChildTheme::enqueue_scripts', 1000 );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'parallax_enqueue_scripts_styles', 1000 );
function parallax_enqueue_scripts_styles() {
// Styles
wp_enqueue_style( 'icomoon-fonts', get_stylesheet_directory_uri() . '/icomoon.css', array() );
wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/style.css', array() );

// Scripts
wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/scripts.js', array() );
}

// Removes Query Strings from scripts and styles
function remove_script_version( $src ){
    if ( strpos( $src, 'uploads/bb-plugin' ) !== false || strpos( $src, 'uploads/bb-theme' ) !== false ) {
      return $src;
    }
    else {
      $parts = explode( '?ver', $src );
      return $parts[0];
    }
  }
  add_filter( 'script_loader_src', 'remove_script_version', 15, 1 );
  add_filter( 'style_loader_src', 'remove_script_version', 15, 1 );
  
  // Add Additional Image Sizes
  add_image_size( 'news-thumb', 260, 150, true );
  add_image_size( 'news-full', 800, 300, false );
  add_image_size( 'mailchimp', 564, 9999, false );
  add_image_size( 'amp', 600, 9999, false );
  add_image_size( 'feature-product', 282, 223, false );
  add_image_size( 'shop-page', 329, 261, false );
  add_image_size( 'home-news', 350, 171, true );
  add_image_size( 'subpage-header', 536, 221, true );
  
  // Gravity Forms confirmation anchor on all forms
  add_filter( 'gform_confirmation_anchor', '__return_true' );
  
  //Sets the number of revisions for all post types
  add_filter( 'wp_revisions_to_keep', 'revisions_count', 10, 2 );
  function revisions_count( $num, $post ) {
      $num = 3;
      return $num;
  }
  
  // Enable Featured Images in RSS Feed and apply Custom image size so it doesn't generate large images in emails
  function featuredtoRSS($content) {
  global $post;
  if ( has_post_thumbnail( $post->ID ) ){
  $content = '<div>' . get_the_post_thumbnail( $post->ID, 'mailchimp', array( 'style' => 'margin-bottom: 15px;' ) ) . '</div>' . $content;
  }
  return $content;
  }
   
  add_filter('the_excerpt_rss', 'featuredtoRSS');
  add_filter('the_content_feed', 'featuredtoRSS');

//Change the breadcrumb separator
add_filter( 'woocommerce_breadcrumb_defaults', 'ba_change_breadcrumb_delimiter' );
function ba_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = ' &gt; ';
	return $defaults;
}

//Product Ordering
function custom_order_products_by_publish_date( $q ) {
  $q->set( 'orderby', 'date' );
  $q->set( 'order', 'DESC' ); // Change to 'ASC' for ascending order.
}
add_action( 'woocommerce_product_query', 'custom_order_products_by_publish_date' );


//Change product meta position
add_action('wp', function() {
  // Remove the default action with priority 40
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
  // Add the action with a new priority of 7
  add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7);
}, 1000);

//Remove related products output
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

//Remove "Description" Heading Title @ WooCommerce Single Product Tabs
add_filter( 'woocommerce_product_description_heading', '__return_null' );

//Remove "Description" Heading Title @ WooCommerce Single Product Tabs
add_filter( 'woocommerce_product_additional_information_heading', '__return_null' );



//Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style( 'font-awesome' ); // FontAwesome 4
    wp_enqueue_style( 'font-awesome-5' ); // FontAwesome 5

    wp_dequeue_script( 'bootstrap' );
    wp_dequeue_script( 'jquery-fitvids' );
    wp_dequeue_script( 'jquery-waypoints' );
}, 9999 );

/* Site Optimization - Removing several assets from Home page that we dont need */

// Remove Assets from HOME page only
function remove_home_assets() {
  if (is_front_page()) {
      
	  wp_dequeue_style('upsell-order-bump-offer-for-woocommercerecommendated_popup');
    wp_dequeue_style('woocommerce-pre-orders-main-css');
    wp_dequeue_style('yoast-seo-adminbar');
    wp_dequeue_style('addtoany');
    wp_dequeue_style('jquery-magnificpopup');
	  wp_dequeue_style('font-awesome');
    wp_dequeue_style('wc-blocks-vendors-style');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('woocommerce-layout');
    wp_dequeue_style('woocommerce-smallscreen');
    wp_dequeue_style('woocommerce-general');
	  
    wp_dequeue_script('addtoany-core');
    wp_dequeue_script('addtoany-jquery');
    wp_dequeue_script('wps-ubo-lite-public-script-for-fbt');
    wp_dequeue_script('jquery-magnificpopup');
    wp_dequeue_script('preorders-field-date-js');
    wp_dequeue_script('preorders-main-js');
    wp_dequeue_script('sourcebuster-js');
  }
  
};
add_action( 'wp_enqueue_scripts', 'remove_home_assets', 9999 );


//Removing unused Default Wordpress Emoji Script - Performance Enhancer
function disable_emoji_dequeue_script() {
    wp_dequeue_script( 'emoji' );
}
add_action( 'wp_print_scripts', 'disable_emoji_dequeue_script', 100 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Removes Emoji Scripts 
add_action('init', 'remheadlink');
function remheadlink() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	remove_action('wp_head', 'wp_shortlink_header', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
}