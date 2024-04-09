<?php
// If this file is called directly, abort.
defined('ABSPATH') || exit;

class DPG_Extension extends DiviExtension
{

    /**
     * The gettext domain for the extension's translations.
     *
     * @var string
     * @since 1.0.0
     */
    public $gettext_domain = 'divi-pro-gallery';

    /**
     * The extension's WP Plugin name.
     *
     * @var string
     * @since 1.0.0
     */
    public $name = 'divi-pro-gallery';

    /**
     * The extension's version
     *
     * @var string
     * @since 1.0.0
     */
    public $version = DPG_VERSION;

    /**
     * DIEL_Divielite constructor.
     *
     * @param string $name
     * @param array  $args
     */
    public function __construct($name = 'divi-pro-gallery', $args = [])
    {
        $this->plugin_dir     = plugin_dir_path(__FILE__);
        $this->plugin_dir_url = plugin_dir_url($this->plugin_dir);
        parent::__construct($name, $args);
    }

    protected function _enqueue_bundles()
    {
    }

    protected function _enqueue_backend_styles()
    {
    }

    public function wp_hook_enqueue_scripts()
    {
    }
}

new DPG_Extension;
