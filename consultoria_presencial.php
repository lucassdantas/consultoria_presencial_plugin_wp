<?php
/**
* Plugin Name: Consultoria presencial
* Plugin URI: https://github.com/lucassdantas/consultoria_presencial_plugin_wp.git
* Description: Consultoria presencial
* Version: 0.1
* Author: Lucas Dantas
* Author URI: lucassdantas.github.io
**/

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}

function consultoria_presencial_endpoint() {
    add_rewrite_endpoint( 'premium-support', EP_ROOT | EP_PAGES );
}
  
add_action( 'init', 'consultoria_presencial_endpoint' );
  
// ------------------
// 2. Add new query var
  
function consultoria_presencial( $vars ) {
    $vars[] = 'consultoria-presencial';
    return $vars;
}
  
add_filter( 'query_vars', 'consultoria_presencial', 0 );
  
// ------------------
// 3. Insert the new endpoint into the My Account menu
  
function add_consultoria_presencial_tab( $items ) {
    $items['consultoria-presencial'] = 'Consultoria Presencial';
    return $items;
}
  
add_filter( 'woocommerce_account_menu_items', 'add_consultoria_presencial_tab' );
  
// ------------------
// 4. Add content to the new tab
  
function conteudo_consultoria_presencial() {
    echo '<h3>Sua consultoria presencial</h3>';
    #echo do_shortcode( ' /* your shortcode here */ ' );
}
  
add_action( 'woocommerce_account_premium-support_endpoint', 'conteudo_consultoria_presencial' );
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format