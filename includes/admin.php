<?php

namespace Divi_Pro_Gallery\Includes;

use Divi_Pro_Gallery\Includes\Helper;
use Divi_Pro_Gallery\Includes\Licenser;

class Admin
{
    private static $script_debug = null;

    const PAGE_ID = 'divi-pro-gallery';

    public function register_page()
    {
        $menu_text = __('Pro Gallery', 'diiv-pro-gallery');

        $page_hook_suffix = add_submenu_page(
            'et_divi_options',
            $menu_text,
            $menu_text,
            'manage_options',
            self::PAGE_ID,
            [$this, 'display_page']
        );

        add_action("admin_print_scripts-{$page_hook_suffix}", array($this, 'enqueue_options_assets'));
    }


    public static function is_script_debug()
    {
        if (null === self::$script_debug) {
            self::$script_debug = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG;
        }

        return self::$script_debug;
    }


    public function enqueue_options_assets()
    {
        $manifest_json = file_get_contents(DPG_PATH . 'assets/mix-manifest.json'); // phpcs:ignore
        $manifest_json = json_decode($manifest_json, true);
        $dashboardJS      = DPG_URL . 'assets' . $manifest_json['/dashboard/index.js'];
        $dashboardCSS   = DPG_URL . 'assets' . $manifest_json['/dashboard/style.css'];

        wp_enqueue_style(
            'dpg-styles',
            self::is_script_debug() ? $dashboardCSS : DPG_URL . 'assets/dashboard/style.css',
            ['wp-components'],
            DPG_VERSION
        );

        wp_enqueue_script(
            'dpg-scripts',
            self::is_script_debug() ? $dashboardJS : DPG_URL . 'assets/dashboard/index.js',
            ['react', 'wp-api', 'wp-i18n', 'lodash', 'wp-components', 'wp-element', 'wp-api-fetch', 'wp-data', 'wp-core-data',  'wp-notices'],
            DPG_VERSION,
            true
        );

        wp_set_script_translations('dpg-scripts', 'divi-pro-gallery');

        wp_localize_script(
            'dpg-scripts',
            'dpgObj',
            [
                'version'            => DPG_VERSION,
                'assetsPath'         => DPG_URL . 'assets/',
                'self_hosted'        => DPG_SELF_HOSTED_ACTIVE,

                'license'        => [
                    'key'    => Licenser::get_license_key(),
                    'status' => Licenser::get_license_status(),
                    'expiration' => __('Lifetime', 'diiv-pro-gallery'),
                ],
            ]
        );
    }

    public function maybe_redirect()
    {
        if (!get_option('dpg_settings_redirect')) {
            return;
        }

        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if (is_network_admin() || isset($_GET['activate-multi'])) { // phpcs:ignore WordPress.VIP.SuperGlobalInputUsage.AccessDetected,WordPress.Security.NonceVerification.NoNonceVerification
            return;
        }

        update_option('dpg_settings_redirect', false);
        wp_safe_redirect(admin_url('admin.php?page=divi-pro-gallery'));
        exit;
    }

    public function register_settings()
    {
        register_setting(
            'dpg_settings',
            'dpg_settings_redirect',
            [
                'type'         => 'boolean',
                'description'  => __('Redirect on new install.', 'divi-pro-gallery'),
                'show_in_rest' => true,
                'default'      => true,
            ]
        );
    }

    public function display_page()
    {
        echo '<div id="dpg-dashboard"></div>';
    }

    public static function get_system_status()
    {
        $bloginfo = get_bloginfo('version');
        $environments = [
            [
                'data' => [
                    [
                        'label'  => __('WP Version', 'divi-pro-gallery'),
                        'status' => 'v' . $bloginfo,
                        'state'  => version_compare($bloginfo, DPG_MIN_WP, '>=') ? 'true' : 'false',
                    ],
                    [
                        'label'  => __('WP Max Upload Size', 'divi-pro-gallery'),
                        'status' => Helper::get_max_upload_size(),
                        'state'  => 'none',
                    ],
                    [
                        'label'  => __('WP Memory Usage', 'divi-pro-gallery'),
                        'status' => Helper::get_memory_usage() . ' / ' . Helper::get_memory_limit(),
                        'state'  => 'none',
                    ],
                    [
                        'label'  => __('WP Debug Mode', 'divi-pro-gallery'),
                        'status' => Helper::get_debug_mode() ? __('Yes', 'divi-pro-gallery') : __('No', 'divi-pro-gallery'),
                        'state'  => Helper::get_debug_mode() ? 'true' : 'false',
                    ],
                    [
                        'label'  => __('Server Info', 'divi-pro-gallery'),
                        'status' => Helper::get_server_software(),
                        'state'  => 'none',
                    ],
                    [
                        'label'  => __('PHP version', 'divi-pro-gallery'),
                        'status' => 'v' . PHP_VERSION,
                        'state'  => version_compare(PHP_VERSION, DPG_MIN_PHP, '>=') ? 'true' : 'false',
                    ],

                    [
                        'label'  => __('PHP Post Max Size', 'wp-grid-builder'),
                        'status' => Helper::get_post_max_size(),
                        'state'  => 'none',
                    ],
                ]
            ],
        ];

        return wp_json_encode($environments);
    }

    public function __construct()
    {
        if ('true' != DPG_SELF_HOSTED_ACTIVE) {
            return;
        }

        add_action('init', [$this, 'register_settings'], 99);
        add_action('admin_menu', [$this, 'register_page'], 99);
        add_action('admin_init', [$this, 'maybe_redirect']);
    }
}
