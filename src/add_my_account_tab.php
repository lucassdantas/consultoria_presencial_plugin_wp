<?php 

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}
function mostrar_id_usuario_atual() {
    // Verifica se o usuário está logado
    if (is_user_logged_in()) {
        // Obtém o ID do usuário atual
        $user_id = get_current_user_id();
        
        // Retorna o ID do usuário
        return $user_id;
    } else {
        return 'Nenhum usuário logado.';
    }
}
add_shortcode('mostrar_id_usuario', 'mostrar_id_usuario_atual');

function consultoria_presencial_endpoint() {
    add_rewrite_endpoint( 'consultoria-presencial', EP_ROOT | EP_PAGES );
}
  
add_action( 'init', 'consultoria_presencial_endpoint' );
  
function consultoria_presencial( $vars ) {
    $vars[] = 'consultoria-presencial';
    return $vars;
}
  
add_filter( 'query_vars', 'consultoria_presencial', 0 );
  
function add_consultoria_presencial_tab( $items ) {
    $items['consultoria-presencial'] = 'Consultoria Presencial';
    return $items;
}
  

add_filter( 'woocommerce_account_menu_items', 'add_consultoria_presencial_tab' );
  
function conteudo_consultoria_presencial() {
    $user_id = get_current_user_id(); 
    $meta_key = 'agendamentos-presenciais-disponiveis'; 
    echo '<h3>Sua consultoria presencial</h3>';
    echo '<p> seu ID: ' . do_shortcode('[mostrar_id_usuario]' . '</p>'); 
    echo '<p>Agendamentos disponíveis: '. get_user_meta($user_id, $meta_key, true) .'</p>';
    if( get_user_meta($user_id, $meta_key, true) > 0){
        echo do_shortcode('[ameliastepbooking]');
    } else {
        echo '<p>Você está sem agendamentos disponíveis!</p>';
    }
    #echo do_shortcode( ' /* your shortcode here */ ' );
}
  
add_action( 'woocommerce_account_consultoria-presencial_endpoint', 'conteudo_consultoria_presencial' );
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format