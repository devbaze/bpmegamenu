<?php

/**
 * Plugin Name: dev-mega-menu
 * Plugin URI: https://zealfa.com
 * Description: Mega menu by Benjamin Pelto
 * Version: 1
 * Author: Benjamin Pelto
 * Author URI: https://zealfa.com
 */


namespace BPMENUMEGAMENU;


if (!defined('ABSPATH')) {
    exit; // izadji
}

define('BPMENUMEGAMENU_VERSION', '1');
define('BPMENUMEGAMENU__FILE__', __FILE__);
define('BPMENUMEGAMENU_PLUGIN_BASE', plugin_basename(BPMENUMEGAMENU__FILE__));
define('BPMENUMEGAMENU_PATH', plugin_dir_path(BPMENUMEGAMENU__FILE__));
define('BPMENUMEGAMENU_URL', plugin_dir_url(BPMENUMEGAMENU__FILE__));



// Widgets
require BPMENUMEGAMENU_PATH . 'widgets/init.php';


// Ucitaj kod
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('bpmenu-mega', BPMENUMEGAMENU_URL . 'assets/css/bpmenu-mega.css');
    wp_enqueue_script('bpmenu-mega', BPMENUMEGAMENU_URL . 'assets/js/bpmenu-mega.js', ['jquery'], '1.0.0', true);
});
