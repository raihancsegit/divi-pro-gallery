<?php

namespace Divi_Pro_Gallery;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Divi_Pro_Gallery\Includes\Attachment;
use Divi_Pro_Gallery\Includes\Admin;
use Divi_Pro_Gallery\Includes\Updater;
use Divi_Pro_Gallery\Includes\Licenser;

class Plugin
{

    private static $instance     = null;
    private static $script_debug = null;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function register_frontend_scripts()
    {

        $js_files = [
            'dpg-splide'          => [
                'path'      => 'assets/lib/splide/splide.min.js',
                'dep'       => '',
                'in_footer' => true,
            ],
            'dpg-isotope'         => [
                'path'      => 'assets/lib/isotope/isotope.pkgd.min.js',
                'dep'       => ['jquery'],
                'in_footer' => true,
            ],
            'dpg-isotope-packery' => [
                'path'      => 'assets/lib/isotope/packery-mode.pkgd.min.js',
                'dep'       => ['jquery'],
                'in_footer' => true,
            ],
            'dpg-fancybox'        => [
                'path'      => 'assets/lib/fancybox/fancybox.min.js',
                'dep'       => ['jquery'],
                'in_footer' => true,
            ],
        ];

        foreach ($js_files as $handle => $data) {
            wp_register_script(
                $handle,
                DPG_URL . $data['path'],
                $data['dep'],
                DPG_VERSION,
                $data['in_footer']
            );
        }

        $manifest_json = file_get_contents(DPG_PATH . 'assets/mix-manifest.json'); // phpcs:ignore
        $manifest_json = json_decode($manifest_json, true);
        $frontendJS    = DPG_URL . 'assets' . $manifest_json['/js/frontend.js'];
        $frontendCSS   = DPG_URL . 'assets' . $manifest_json['/css/frontend.css'];

        wp_register_script(
            'dpg-frontend',
            self::is_script_debug() ? $frontendJS : DPG_URL . 'assets/js/frontend.js',
            ['jquery', 'dpg-isotope', 'dpg-isotope-packery', 'dpg-fancybox', 'dpg-splide'],
            DPG_VERSION,
            true
        );

        // Register styles
        wp_register_style(
            'dpg-fancybox',
            DPG_URL . 'assets/lib/fancybox/fancybox.min.css',
            [],
            DPG_VERSION
        );

        wp_register_style(
            'dpg-splide',
            DPG_URL . 'assets/lib/splide/splide.min.css',
            [],
            DPG_VERSION
        );

        wp_register_style(
            'dpg-frontend',
            self::is_script_debug() ? $frontendCSS : DPG_URL . 'assets/css/frontend.css',
            ['dpg-fancybox', 'dpg-splide'],
            DPG_VERSION
        );
    }

    public function register_builder_scripts()
    {

        if (!et_core_is_fb_enabled()) {
            return;
        }

        $manifest_json = file_get_contents(DPG_PATH . 'assets/mix-manifest.json'); // phpcs:ignore
        $manifest_json = json_decode($manifest_json, true);
        $bundleJS      = DPG_URL . 'assets' . $manifest_json['/js/bundle.js'];
        $bundleCSS   = DPG_URL . 'assets' . $manifest_json['/css/bundle.css'];

        wp_enqueue_script(
            'dpg-bundle',
            self::is_script_debug() ? $bundleJS : DPG_URL . 'assets/js/bundle.js',
            ['react-dom', 'react', 'dpg-frontend'],
            DPG_VERSION,
            true
        );

        wp_enqueue_style(
            'dpg-bundle',
            self::is_script_debug() ? $bundleCSS : DPG_URL . 'assets/css/bundle.css',
            ['dpg-splide'],
            DPG_VERSION
        );
    }

    public static function is_script_debug()
    {
        if (null === self::$script_debug) {
            self::$script_debug = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG;
        }

        return self::$script_debug;
    }

    public function extensions_init()
    {
        require_once DPG_PATH . '/includes/extension.php';
    }

    private function setup_hooks()
    {
        add_action('divi_extensions_init', [$this, 'extensions_init']);
        add_action('wp_enqueue_scripts', [$this, 'register_frontend_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'register_builder_scripts'], 999);
    }

    private static function autoload($class_name)
    {

        if (0 !== strpos($class_name, __NAMESPACE__)) {
            return;
        }

        $file_name = strtolower(
            preg_replace(
                ['/\b' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/'],
                ['', '$1-$2', '-', DIRECTORY_SEPARATOR],
                $class_name
            )
        );

        $file = plugin_dir_path(__FILE__) . $file_name . '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }

    private function __construct()
    {
        spl_autoload_register([$this, 'autoload']);
        new Attachment();

        if (is_admin()) {
            new Admin();
        }

        if ('true' === DPG_SELF_HOSTED_ACTIVE) {
            new Licenser();
            new Updater(
                plugin_basename(DPG_FILE),
                plugin_basename(DPG_DIR),
                DPG_VERSION,
                DPG_API_URL
            );
        }

        $this->setup_hooks();
    }
}

Plugin::get_instance();
