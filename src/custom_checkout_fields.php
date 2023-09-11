<?php 

add_filter('woocommerce_checkout_fields', 'custom_date_field');
function custom_date_field($fields)
{	
    $fields['billing']['booking_quantity'] = array(
        'label'     => __('Total de agendamentos', 'woocommerce'),
        'type'		=> 'text',
        'placeholder'   => _x('Total de agendamentos que irá adquirir', 'placeholder', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-wide'),
        'default'   => $GLOBALS['current_booking_quantity'],
        'custom_attributes' => array(
            'readonly' => 'readonly', // Set the field to readonly
        ),
    );
	
	$fields['billing']['booking_quantity']['priority'] = 9;
    return $fields;
}

// Salvar os campos como metadados da ordem
add_action('woocommerce_checkout_update_order_meta', 'save_custom_shipping_fields');

function save_custom_shipping_fields($order_id) {
	if ($_POST['booking_quantity']) {
		update_post_meta($order_id, '_booking_quantity', sanitize_text_field($_POST['booking_quantity']));
    }
}

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'display_booking_quantity_on_order', 10, 1 );

function display_booking_quantity_on_order($order){
	$shippingType =  get_post_meta( $order->get_id(), 'booking_quantity', true );
	echo '<p><strong>'.__('Tipo de entrega:').'</strong> ' . $shippingType . '</p>';
}
