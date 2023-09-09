<?php
/**
* Plugin Name: Consultoria presencial
* Plugin URI: https://github.com/lucassdantas/consultoria_presencial_plugin_wp.git
* Description: Consultoria presencial
* Version: 0.2
* Author: Lucas Dantas
* Author URI: lucassdantas.github.io
**/

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}

require_once plugin_dir_path( __FILE__ ). 'src/add_my_account_tab.php';

add_action('woocommerce_before_checkout_form', 'update_user_booking_quantity');

function update_user_booking_quantity($booking_quantity = 1){
    $user_id = get_current_user_id(); 
    $meta_key = 'agendamentos-presenciais-disponiveis'; 
    
    $old_meta_value = get_user_meta($user_id, $meta_key, true);
    $new_meta_value = 1;#strval(intval($old_meta_value) + $booking_quantity);
    update_user_meta($user_id, $meta_key, $new_meta_value);
}

// Hook into the 'woocommerce_payment_complete' action.
add_action('woocommerce_payment_complete', 'check_payment_status');

function check_payment_status($order_id) {
    // Get the order object
    $order = wc_get_order($order_id);
    // echo '<pre>';
    // print_r($order);
    // echo '</pre>';
    // Check if the order is completed and paid
    if ($order->has_status('completed') && $order->is_paid()) {
        update_user_booking_quantity();
        // Payment was successful, process the order
        // You can add your custom code here to handle a successful payment
        // For example, update order status, send confirmation emails, etc.
    } else {
        // Payment was not successful
        // You can handle unsuccessful payments here
    }
}

add_action('AmeliaBookingAddedBeforeNotify', 'update_booking_quantity_when_book');

function update_booking_quantity_when_book($booking_id) {
    update_user_booking_quantity(-1);
}