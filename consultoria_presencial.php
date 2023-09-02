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