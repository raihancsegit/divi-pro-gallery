<?php

namespace Divi_Pro_Gallery\Includes;

class Licenser
{
    /**
     * Lemon squeezy api url
     */
    public $api_url = 'https://api.lemonsqueezy.com';

    /**
     * Constructor for Licenser.
     */
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * Register the routes for the objects of the license.
     */
    public function register_routes()
    {
        register_rest_route(
            'divi-pro-gallery/v1',
            '/toggle_license',
            [
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [$this, 'toggle_license'],
                    'args'                => array(
                        'key'    => array(
                            'type'              => 'string',
                            'sanitize_callback' => function ($key) {
                                return (string) esc_attr($key);
                            },
                            'validate_callback' => function ($key) {
                                return is_string($key);
                            },
                        ),
                        'action' => array(
                            'type'              => 'string',
                            'sanitize_callback' => function ($key) {
                                return (string) esc_attr($key);
                            },
                            'validate_callback' => function ($key) {
                                return in_array($key, ['activate', 'deactivate'], true);
                            },
                        ),
                    ),
                    'permission_callback' => function () {
                        return current_user_can('manage_options');
                    },
                ]
            ]
        );
    }

    /**
     * Toggle License
     */
    public function toggle_license($request)
    {

        $params        = $request->get_json_params();
        $license_key   = $params['key'];
        $action        = $params['action'];
        $is_valid      = false;
        $error_message = '';

        if ('active' === $this->get_license_status() && 'activate' === $action) {
            return new \WP_REST_Response(
                [
                    'success' => $is_valid,
                    'message' => __('License is already active', 'divi_pro_gallery'),
                ],
                401
            );
        }

        if ('active' !== $this->get_license_status() && 'deactivate' === $action) {
            return new \WP_REST_Response(
                [
                    'success' => $is_valid,
                    'message' => __('License not active', 'divi-pro-gallery'),
                ],
                401
            );
        }

        if (!isset($license_key) || !isset($action)) {
            return new \WP_REST_Response(
                [
                    'success' => $is_valid,
                    'message' => __('Unauthorized request', 'divi-pro-gallery'),
                ],
                401
            );
        }

        $instance_arr = 'activate' === $action ? ['instance_name' => home_url()] : ['instance_id' => self::get_instance_id()];
        $license_arr  = ['license_key' => $license_key];

        $response = wp_remote_post(
            $this->api_url . '/v1/licenses/' . $action,
            [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Cache-Control' => 'no-cache',
                ],
                'body'    => $instance_arr + $license_arr,
            ]
        );

        if (!is_wp_error($response)) {
            if (200 === wp_remote_retrieve_response_code($response)) {
                $is_valid     = true;
                $license_data = json_decode(wp_remote_retrieve_body($response));
                self::set_data($license_data, $action);
            } else {
                $error_message = wp_remote_retrieve_response_message($response);
                return new \WP_REST_Response(
                    [
                        'message' => $error_message,
                        'success' => false,
                    ]
                );
            }
        } else {
            $error_message = $response->get_error_message();
            return new \WP_REST_Response(
                [
                    'message' => $error_message,
                    'success' => false,
                ]
            );
        }

        return new \WP_REST_Response(
            [
                'success' => $is_valid,
                'message' => 'activate' === $action ? __('Activated', 'divi-pro-gallery') : __('Deactivated', 'divi-pro-gallery'),
                'license' => [
                    'key'        => $license_data->license_key->key,
                    'status'     => $license_data->license_key->status,
                    'expiration' => 'lifetime',
                ],
            ],

            $is_valid ? 200 : 400
        );
    }

    /**
     * Get license data
     */
    public static function get_data()
    {
        return get_option('dpg_license_data', '');
    }

    /**
     * Save license data
     */
    private static function set_data($data, $action)
    {

        if ('activate' === $action) {

            update_option('dpg_license_data', $data);
            set_transient('dpg_license_data', $data, 12 * HOUR_IN_SECONDS);
        } else if ('deactivate' === $action) {

            delete_option('dpg_license_data');
            delete_transient('dpg_license_data');
        }
    }

    /**
     * Set licesne key
     */
    private static function set_license_key($data)
    {

        if (empty($data)) {
            return '';
        } else if (!isset($data->license_key->key)) {
            return '';
        }

        // Save license key
        update_option('dpg_license_key', $data->license_key->key);

        return get_option('dpg_license_key');
    }

    /**
     * Get licesne key
     */
    public static function get_license_key()
    {
        return self::set_license_key(self::get_data());
    }

    /**
     * Set licesne status
     */
    private static function set_license_status($data)
    {

        if (empty($data)) {
            return '';
        } else if (!isset($data->license_key->status)) {
            return '';
        }

        // Save license key
        update_option('dpg_license_status', $data->license_key->status);

        return get_option('dpg_license_status');
    }

    /**
     * Get licesne status
     */
    public static function get_license_status()
    {
        return self::set_license_status(self::get_data());
    }

    /**
     * Set licesne status
     */
    private static function set_instance_id($data)
    {

        if (empty($data)) {
            return '';
        } else if (!isset($data->instance->id)) {
            return '';
        }

        // Save license key
        update_option('dpg_instance_id', $data->instance->id);

        return get_option('dpg_instance_id');
    }

    /**
     * Get licesne status
     */
    public static function get_instance_id()
    {
        return self::set_instance_id(self::get_data());
    }
}
