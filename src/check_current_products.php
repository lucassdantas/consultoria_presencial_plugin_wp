<?php 

add_action('woocommerce_before_checkout_form', 'get_products_slug');
function get_products_slug() {
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        $product = $cart_item['data'];
        if(!empty($product)){
            $product_slug = get_post($product->get_id())->post_name;
            echo '<pre>';
            print_r($product_slug);
            echo '</pre>';
            // to display only the first product image uncomment the line below
            // break;
        }
    }
}