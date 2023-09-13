<?php
/**
* Plugin Name: Consultoria presencial
* Plugin URI: https://github.com/lucassdantas/consultoria_presencial_plugin_wp.git
* Description: Consultoria presencial
* Version: 0.25
* Author: Lucas Dantas
* Author URI: lucassdantas.github.io
**/

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}
global $current_booking_quantity; 
$GLOBALS['current_booking_quantity'] = get_user_meta(get_current_user_id(), 'agendamentos-presenciais-disponiveis', true);

require_once plugin_dir_path( __FILE__ ). 'src/add_my_account_tab.php';

//remover esse action depois
#add_action('woocommerce_before_checkout_form', 'update_user_booking_quantity');
function update_user_booking_quantity($booking_quantity = 1){
    $user_id = get_current_user_id(); 
    $meta_key = 'agendamentos-presenciais-disponiveis'; 
    if(is_int($booking_quantity)){
        $old_meta_value = get_user_meta($user_id, $meta_key, true);
        $new_meta_value = strval(intval($old_meta_value) + $booking_quantity);

        update_user_meta($user_id, $meta_key, $new_meta_value);
    }
}
require_once plugin_dir_path(__FILE__) . 'src/custom_checkout_fields.php';

add_action('woocommerce_payment_complete', 'check_payment_status_and_update_meta');
function check_payment_status_and_update_meta($order_id) {
    $order = wc_get_order($order_id);
    if ($order->has_status('completed') && $order->is_paid()) {
        update_user_booking_quantity($GLOBALS['current_booking_quantity']);
        echo '<p id="booking_quantity"> adicionado </p>';
    } else {

    }
}

add_action('AmeliaBookingAddedBeforeNotify', 'update_booking_quantity_when_book');
function update_booking_quantity_when_book($booking_id) {
    update_user_booking_quantity(-1);
}