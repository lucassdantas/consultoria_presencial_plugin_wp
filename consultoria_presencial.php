<?php
/**
* Plugin Name: Consultoria presencial
* Plugin URI: https://github.com/lucassdantas/consultoria_presencial_plugin_wp.git
* Description: Consultoria presencial
* Version: 0.30
* Author: Lucas Dantas
* Author URI: lucassdantas.github.io
**/

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}
global $current_booking_quantity; 
$GLOBALS['current_booking_quantity'] = get_user_meta(get_current_user_id(), 'agendamentos-presenciais-disponiveis', true);

require_once plugin_dir_path(__FILE__) . 'src/check_current_products.php';
require_once plugin_dir_path( __FILE__ ). 'src/add_my_account_tab.php';

function update_user_booking_quantity($booking_quantity = 1, $user_id){
    $meta_key = 'agendamentos-presenciais-disponiveis'; 
    $old_meta_value = get_user_meta($user_id, $meta_key, true);
    $new_meta_value = strval(intval($old_meta_value) + intval($booking_quantity));

    update_user_meta($user_id, $meta_key, $new_meta_value);
}
require_once plugin_dir_path(__FILE__) . 'src/custom_checkout_fields.php';

add_action('woocommerce_order_status_completed', 'check_payment_status_and_update_meta');
function check_payment_status_and_update_meta($order_id) {
    $order = wc_get_order( $order_id );
    $user_id = $order->get_user_id();
    if ( $order->get_customer_ip_address() ) {  
        $current_booking = get_post_meta( $order->get_id(), '_booking_quantity', true );
        if($current_booking > 0) update_user_booking_quantity($current_booking, $user_id);
    }
    /*
    $order = wc_get_order($order_id);
    if ($order->has_status('completed') && $order->is_paid()) {
        update_user_booking_quantity($GLOBALS['current_booking_quantity']);
        echo '<p id="booking_quantity"> adicionado </p>';
    } else {

    }*/
}

add_action('AmeliaBookingAddedBeforeNotify', 'update_booking_quantity_when_book');
function update_booking_quantity_when_book($booking_id) {
    update_user_booking_quantity(-1);
}

