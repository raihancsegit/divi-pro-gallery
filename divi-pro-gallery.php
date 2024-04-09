<?php

/**
 * Plugin Name: Divi Pro Gallery
 * Description: Design a beautiful gallery on your Divi site in less than 1 minute!
 * Plugin URI: https://progallery.wppaw.com/
 * Author URI: https://wppaw.com
 * Version: 1.0.4
 * Author: WPPaw
 * Text Domain: divi-pro-gallery
 * Domain Path: /languages
 */

defined('ABSPATH') or die;

define('DPG_VERSION', '1.0.4');
define('DPG_SLUG', 'dpg');
define('DPG_MIN_PHP', '7.0.0');
define('DPG_MIN_WP', '5.0');
define('DPG_FILE', __FILE__);
define('DPG_DIR', __DIR__);
define('DPG_PATH', plugin_dir_path(__FILE__));
define('DPG_URL', plugin_dir_url(__FILE__));
define('DPG_SELF_HOSTED_ACTIVE', 'true');

if (!defined('DPG_API_URL')) {
    define('DPG_API_URL', 'https://progallery.wppaw.com/wp-json/lsq/v1');
}

function dpg_load_plugin()
{
    load_plugin_textdomain('divi-pro-gallery', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    require DPG_PATH . 'plugin.php';
}

add_action('plugins_loaded', 'dpg_load_plugin');
