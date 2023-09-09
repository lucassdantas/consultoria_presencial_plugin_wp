<?php 

#add_action('woocommerce_before_checkout_form', 'update_current_temp_booking_quantity');
function update_temp_booking_quantity() {
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        $product = $cart_item['data'];
        if(!empty($product)){
            $product_slug = get_post($product->get_id())->post_name;
            switch ($product_slug) {
                case 'consultoria-presencial-unica':
                    $GLOBALS['current_booking_quantity'] += 1;
                    break;
                
                case 'consultoria-presencial-3-consultas':
                    $GLOBALS['current_booking_quantity'] += 3;
                    break;
                    
                
                case 'consultoria-presencial-6-consultas':
                    $GLOBALS['current_booking_quantity'] += 6;
                    break;

                default:
                    
                    break;
            }
            // to display only the first product image uncomment the line below
            // break;
        }
    }
}

