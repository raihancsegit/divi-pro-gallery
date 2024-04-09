<?php
// If this file is called directly, abort.
defined('ABSPATH') || exit;

use Divi_Pro_Gallery\Includes\Helper;

/**
 * The Gallery module class.
 */
class DPG_Gallery extends ET_Builder_Module
{
    protected $settings;

    const MAIN_CSS_ELEMENT = '%%order_class%%.dpg-gallery';

    protected $module_credits = [
        'module_uri' => 'https://divielite.com/pro-gallery',
        'author'     => 'WPPaw',
        'author_uri' => 'https://wppaw.com',
    ];

    public function init()
    {

        $this->name             = esc_html__('Pro Gallery', 'divi-pro-gallery');
        $this->slug             = 'divi_pro_gallery';
        $this->vb_support       = 'on';
        $this->main_css_element = '%%order_class%%';
        $this->icon_path        = plugin_dir_path(__FILE__) . './pro-gallery.svg';

        $this->settings_modal_toggles = [
            'general'  => [
                'toggles' => [
                    'general'     => esc_html__('General', 'divi-pro-gallery'),
                    'lightbox'    => esc_html__('Lightbox & Links', 'divi-pro-gallery'),
                    'filter_bar' => esc_html__('Filter Bar', 'divi-pro-gallery'),
                    'caption'     => esc_html__('Captions', 'divi-pro-gallery'),
                    'pagination'   => esc_html__('Pagination', 'divi-pro-gallery'),
                    'hover_effect' => esc_html__('Hover Effects', 'divi-pro-gallery'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'overlay'        => esc_html__('Overlay', 'divi-pro-gallery'),
                    'image'        => esc_html__('Image', 'divi-pro-gallery'),
                    'caption'      => esc_html__('Caption', 'divi-pro-gallery'),
                    'caption_text' => [
                        'title'             => esc_html__('Caption Text', 'divi-pro-gallery'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => [
                            'caption_title' => [
                                'name' => esc_html__('Title', 'divi-pro-gallery'),
                            ],
                            'caption_desc'  => [
                                'name' => esc_html__('Description', 'divi-pro-gallery'),
                            ],
                        ],
                    ],
                    'filter_bar'  => esc_html__('Filter Bar', 'divi-pro-gallery'),
                    'filters_text' => [
                        'title'             => esc_html__('Filter Bar Text', 'divi-pro-gallery'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => [
                            'normal' => [
                                'name' => esc_html__('Normal', 'divi-pro-gallery'),
                            ],
                            'active' => [
                                'name' => esc_html__('Active', 'divi-pro-gallery'),
                            ],
                        ],
                    ],
                    'pagination'  => [
                        'title'             => esc_html__('Pagination', 'divi-pro-gallery'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => [
                            'normal' => [
                                'name' => esc_html__('Normal', 'divi-pro-gallery'),
                            ],
                            'active'  => [
                                'name' => esc_html__('Active', 'divi-pro-gallery'),
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->custom_css_fields = [
            'gallery' => [
                'label'    => esc_html__('Gallery', 'divi-pro-gallery'),
                'selector' => '.divi-pro-gallery',
            ],

            'filters' => [
                'label'    => esc_html__('Filters', 'divi-pro-gallery'),
                'selector' => '.dpg-filters',
            ],

            'items'   => [
                'label'    => esc_html__('Items', 'divi-pro-gallery'),
                'selector' => '.dpg-items',
            ],

            'item'    => [
                'label'    => esc_html__('Item', 'divi-pro-gallery'),
                'selector' => '.dpg-item',
            ],

            'image'   => [
                'label'    => esc_html__('Image', 'divi-pro-gallery'),
                'selector' => '.dpg-item .pic',
            ],
        ];
    }

    public function get_fields()
    {
        $general = [

            'gallery_ids'     => [
                'label'            => __('Choose Images', 'divi-pro-gallery'),
                'description'      => __('Choose the images that you would like to appear in the image gallery.', 'divi-pro-gallery'),
                'type'             => 'upload-gallery',
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'general',
                'computed_affects' => [
                    '__gallery',
                ],
            ],

            'image_size'      => [
                'label'            => __('Image Size', 'divi-pro-gallery'),
                'type'             => 'select',
                'description'      => __(' Select the size of your images.', 'divi-pro-gallery'),
                'default'          => array_keys(Helper::get_image_sizes()),
                'options'          => Helper::get_image_sizes(),
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'general',
                'computed_affects' => [
                    '__gallery',
                ],
            ],

            '_layout'         => [
                'type'        => 'dpg_separator',
                '_text'       => __('Gallery Layout', 'divi-pro-gallery'),
                'toggle_slug' => 'general',
            ],

            'gallery_type'    => [
                'label'            => __('Gallery Type', 'divi-pro-gallery'),
                'type'             => 'dpg_layout_selector',
                'default'          => 'grid',
                'options'          => [
                    'grid'      => __('Grid', 'divi-pro-gallery'),
                    'masonry'   => __('Masonry', 'divi-pro-gallery'),
                    'highlight' => __('Highlight', 'divi-pro-gallery'),
                    'slider'    => __('Slider', 'divi-pro-gallery'),
                ],
                'toggle_slug'      => 'general',
                'computed_affects' => [
                    '__gallery',
                ],
            ],

            'columns'         => [
                'label'            => __('Columns', 'divi-pro-gallery'),
                'toggle_slug'      => 'general',
                'type'             => 'select',
                'default'          => '4',
                'options'          => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'mobile_options'   => true,
                'validate_unit'    => true,
                'option_category'  => 'layout',
                'computed_affects' => [
                    '__gallery',
                ],
            ],

            'gutter'          => [
                'label'            => __('Spacing', 'divi-pro-gallery'),
                'toggle_slug'      => 'general',
                'type'             => 'text',
                'option_category'  => 'basic_option',
                'default'          => 20,
                'default_on_front' => 20,
                // 'mobile_options'   => true,
                'computed_affects' => [
                    '__gallery',
                ],
                'validate_unit'    => false,
            ],

            'highlight_count' => [
                'label'            => __('Highlight every', 'divi-pro-gallery'),
                'toggle_slug'      => 'general',
                'type'             => 'text',
                'option_category'  => 'basic_option',
                'default'          => '8',
                'default_on_front' => '8',
                'mobile_options'   => true,
                'computed_affects' => [
                    '__gallery',
                ],
                'show_if'          => [
                    'gallery_type' => 'highlight',
                ],
                'validate_unit'    => false,
            ],

            // Slider options
            '_slideOptions'   => [
                'type'        => 'dpg_separator',
                '_text'       => __('Slider Options', 'divi-pro-gallery'),
                'toggle_slug' => 'general',
                'show_if'     => [
                    'gallery_type' => 'slider',
                ],
            ],

            'slider_type'     => [
                'label'            => esc_html__('Type', 'divi-pro-gallery'),
                'type'             => 'select',
                'options'          => [
                    'loop'  => __('Loop', 'divi-pro-gallery'),
                    'slide' => __('Slide', 'divi-pro-gallery'),
                    'fade'  => __('Fade', 'divi-pro-gallery'),
                ],
                'default'          => 'loop',
                'toggle_slug'      => 'general',
                'show_if'          => [
                    'gallery_type' => 'slider',
                ],
                'computed_affects' => [
                    '__gallery',
                ],
            ],

            'slider_height'   => [
                'label'            => __('Height', 'divi-pro-gallery'),
                'type'             => 'text',
                'default'          => '300px',
                'validate_unit'    => true,
                'toggle_slug'      => 'general',
                'option_category'  => 'basic_option',
                'show_if'          => [
                    'gallery_type' => 'slider',
                ],
                'computed_affects' => [
                    '__gallery',
                ],
            ],

            'slider_speed'    => [
                'label'           => __('Speed', 'divi-pro-gallery'),
                'type'            => 'text',
                'default'         => 400,
                'validate_unit'   => false,
                'toggle_slug'     => 'general',
                'option_category' => 'basic_option',
                'show_if'         => [
                    'gallery_type' => 'slider',
                ],
            ],

            'slider_arrows'   => [
                'label'            => __('Arrows', 'divi-pro-gallery'),
                'type'             => 'yes_no_button',
                'options'          => [
                    'on'  => __('yes', 'divi-pro-gallery'),
                    'off' => __('no', 'divi-pro-gallery'),
                ],
                'default'          => 'on',
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'general',
                'show_if'          => [
                    'gallery_type' => 'slider',
                ],
                'computed_affects' => [
                    '__gallery',
                ],
            ],

            'arrow_size'      => [
                'label'            => __('Arrow size', 'divi-pro-gallery'),
                'type'             => 'text',
                'default'          => 32,
                'default_on_front' => 32,
                'validate_unit'    => false,
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'general',
                'show_if'          => [
                    'gallery_type'  => 'slider',
                    'slider_arrows' => 'on',
                ],
            ],

            'arrow_color'     => [
                'label'           => esc_html__('Arrow color', 'divi-pro-gallery'),
                'type'            => 'color-alpha',
                'default'         => '',
                'custom_color'    => true,
                'mobile_options'  => true,
                'option_category' => 'basic_option',
                'toggle_slug'     => 'general',
                'show_if'         => [
                    'gallery_type'  => 'slider',
                    'slider_arrows' => 'on',
                ],
            ],

            'arrow_bg_color'  => [
                'label'           => esc_html__('Arrow Background color', 'divi-pro-gallery'),
                'type'            => 'color-alpha',
                'default'         => '',
                'custom_color'    => true,
                'mobile_options'  => true,
                'option_category' => 'basic_option',
                'toggle_slug'     => 'general',
                'show_if'         => [
                    'gallery_type'  => 'slider',
                    'slider_arrows' => 'on',
                ],
            ],

            // 'hover_effects'     => [
            //     'label'            => esc_html__('Hover Effects', 'divi-pro-gallery'),
            //     'type'             => 'select',
            //     'options'          => [
            //         'none'  => __('Default', 'divi-pro-gallery'),
            //     ],
            //     'default'          => 'none',
            //     'toggle_slug'      => 'general',
            //     'computed_affects' => [
            //         '__gallery',
            //     ],
            // ],

        ];

        $overlay = [
            'overlay_bg_color' => [
                'label'          => esc_html__('Overlay Color', 'divi-pro-gallery'),
                'type'           => 'color-alpha',
                'default'        => '',
                'custom_color'   => true,
                'mobile_options' => true,
                'tab_slug'       => 'advanced',
                'toggle_slug'    => 'overlay',
            ],

            'overlay_bg_opacity' => [
                'label'            => esc_html__('Opacity', 'divi-pro-gallery'),
                'type'             => 'range',
                'option_category'  => 'font_option',
                'range_settings'   => [
                    'min'  => '0.1',
                    'max'  => '1',
                    'step' => '0.1',
                ],
                'mobile_options'   => true,
                'tab_slug'       => 'advanced',
                'toggle_slug'    => 'overlay',
            ],
        ];

        $click_action = [

            'click_action'     => [
                'label'            => __('Lightbox & Links', 'divi-pro-gallery'),
                'type'             => 'select',
                'default'          => 'lightbox',
                'options'          => [
                    'no-link'    => esc_html__('No Link', 'divi-pro-gallery'),
                    'file'       => esc_html__('Media File', 'divi-pro-gallery'),
                    'attachment' => esc_html__('Attachment Page', 'divi-pro-gallery'),
                    'lightbox'   => esc_html__('Lightbox', 'divi-pro-gallery'),
                    'custom'   => esc_html__('Custom Links', 'divi-pro-gallery'),
                ],
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'lightbox',
                'computed_affects' => [
                    '__gallery',
                ],
            ],

            'lightbox_actions' => [
                'label'            => __('Actions', 'divi-pro-gallery'),
                'type'             => 'multiple_checkboxes',
                'default'          => 'zoom',
                'options'          => [
                    'zoom'       => __('Zoom', 'divi-pro-gallery'),
                    'share'      => __('Social Share', 'divi-pro-gallery'),
                    'slideShow'  => __('Slideshow', 'divi-pro-gallery'),
                    'fullScreen' => __('Full Screen', 'divi-pro-gallery'),
                    'download'   => __('Download', 'divi-pro-gallery'),
                    'thumbs'     => __('Gallery', 'divi-pro-gallery'),
                ],
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'lightbox',
                'computed_affects' => [
                    '__gallery',
                ],
                'show_if'          => [
                    'click_action' => 'lightbox',
                ],
            ],

        ];

        $filters = [

            'hide_filters'          => [
                'label'            => esc_html__('Hide Filters', 'divi-pro-gallery'),
                'description'      => esc_html__('Allow users to filter the gallery images by their tags.', 'divi-pro-gallery'),
                'type'             => 'yes_no_button',
                'options'          => [
                    'on'  => __('yes', 'divi-pro-gallery'),
                    'off' => __('no', 'divi-pro-gallery'),
                ],
                'default'          => 'off',
                'toggle_slug'      => 'filter_bar',
                'computed_affects' => ['__gallery'],
                'show_if'          => [
                    'gallery_type' => ['grid', 'masonry'],
                ],
            ],

            'hide_all_filter'       => [
                'label'            => esc_html__('Hide "All" filter', 'divi-pro-gallery'),
                'type'             => 'yes_no_button',
                'default'          => 'off',
                'options'          => [
                    'on'  => __('yes', 'divi-pro-gallery'),
                    'off' => __('no', 'divi-pro-gallery'),
                ],
                'description'      => esc_html__('Choose to show or hide the “All” filter.', 'divi-pro-gallery'),
                'toggle_slug'      => 'filter_bar',
                'computed_affects' => ['__gallery'],
                'show_if'          => [
                    'gallery_type' => ['grid', 'masonry'],
                    'hide_filters' => 'off',
                ],
            ],

            'all_filter_label'      => [
                'label'            => esc_html__('Text For "All" filter', 'divi-pro-gallery'),
                'type'             => 'text',
                'default'          => esc_html__('All', 'divi-pro-gallery'),
                'description'      => esc_html__('Set the label you want to use for the “All” filter that will contain all the images in your gallery.', 'divi-pro-gallery'),
                'toggle_slug'      => 'filter_bar',
                'computed_affects' => ['__gallery'],
                'show_if'          => [
                    'gallery_type'    => ['grid', 'masonry'],
                    'hide_filters'    => 'off',
                    'hide_all_filter' => 'off',
                ],
            ],

            'filter_spacing_bottom' => [
                'label'           => esc_html__('Bottom Spacing', 'divi-pro-gallery'),
                'type'            => 'text',
                'default'         => '20px',
                'mobile_options'  => true,
                'validate_unit'   => true,
                'option_category' => 'basic_option',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'filter_bar',
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'hide_filters' => 'off',
                ],
            ],

            'filter_alignment'      => [
                'label'           => esc_html__('Alignment', 'divi-pro-gallery'),
                'description'     => esc_html__('Here you can define the alignment of Button', 'divi-pro-gallery'),
                'type'            => 'text_align',
                'option_category' => 'configuration',
                'default'         => 'center',
                'options'         => et_builder_get_text_orientation_options(['justified']),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'filter_bar',
                'mobile_options'  => true,
            ],

            'filter_bg'             => [
                'label'          => esc_html__('Background Color', 'divi-pro-gallery'),
                'type'           => 'color-alpha',
                'default'        => '',
                'custom_color'   => true,
                'mobile_options' => true,
                'tab_slug'       => 'advanced',
                'toggle_slug'    => 'filter_bar',
                'show_if'        => [
                    'gallery_type' => ['grid', 'masonry'],
                    'hide_filters' => 'off',
                ],
            ],

            'filter_bg_active'      => [
                'label'          => esc_html__('Active Background Color', 'divi-pro-gallery'),
                'type'           => 'color-alpha',
                'default'        => '',
                'custom_color'   => true,
                'mobile_options' => true,
                'toggle_slug'    => 'filter_bar',
                'tab_slug'       => 'advanced',
                'show_if'        => [
                    'gallery_type' => ['grid', 'masonry'],
                    'hide_filters' => 'off',
                ],
            ],

            'filter_spacing'        => [
                'label'           => esc_html__('Filter Spacing', 'divi-pro-gallery'),
                'type'            => 'text',
                'default'         => '10px',
                'mobile_options'  => true,
                'validate_unit'   => true,
                'option_category' => 'basic_option',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'filter_bar',
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'hide_filters' => 'off',
                ],
            ],

            'filter_padding'        => [
                'label'           => esc_html__('Filter Padding', 'divi-pro-gallery'),
                'type'            => 'custom_margin',
                'option_category' => 'basic_option',
                'mobile_options'  => true,
                'responsive'      => true,
                'default'         => '5px|15px|5px|15px',
                'toggle_slug'     => 'filter_bar',
                'tab_slug'        => 'advanced',
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'hide_filters' => 'off',
                ],
            ],

            '_filter'               => [
                'type'        => 'dpg_separator',
                '_text'       => __('Filters Border', 'divi-pro-gallery'),
                'toggle_slug' => 'filter_bar',
                'tab_slug'    => 'advanced',
                'show_if'     => [
                    'gallery_type' => ['grid', 'masonry'],
                    'hide_filters' => 'off',
                ],
            ],

        ];

        $pagination = [

            'show_pagination'          => [
                'label'            => esc_html__('Show Pagination', 'divi-pro-gallery'),
                'type'             => 'yes_no_button',
                'options'          => [
                    'on'  => __('yes', 'divi-pro-gallery'),
                    'off' => __('no', 'divi-pro-gallery'),
                ],
                'default'          => 'off',
                'toggle_slug'      => 'pagination',
                'computed_affects' => ['__gallery'],
                'show_if'          => [
                    'gallery_type' => ['grid', 'masonry'],
                ],
            ],

            'items_per_page'          => [
                'label'            => __('Items Per Page', 'divi-pro-gallery'),
                'toggle_slug'      => 'pagination',
                'type'             => 'text',
                'option_category'  => 'basic_option',
                'default'          => 8,
                'default_on_front' => 8,
                'computed_affects' => [
                    '__gallery',
                ],
                'validate_unit'    => false,
                'show_if'          => [
                    'gallery_type' => ['grid', 'masonry'],
                    'show_pagination' => 'on',
                ],
            ],

            'pagination_alignment' => [
                'label'           => esc_html__('Alignment', 'divi-pro-gallery'),
                'description'     => esc_html__('Here you can define the alignment of Button', 'divi-pro-gallery'),
                'type'            => 'select',
                'option_category' => 'configuration',
                'default'         => 'center',
                'options'         => [
                    'flex-start'   => esc_html__('Left', 'divi-pro-gallery'),
                    'center' => esc_html__('Center', 'divi-pro-gallery'),
                    'flex-end'  => esc_html__('Right', 'divi-pro-gallery'),
                ],
                'toggle_slug'     => 'pagination',
                'mobile_options'  => true,
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'show_pagination' => 'on',
                ],
            ],

            'pagination_bg' => [
                'label'          => esc_html__('Background Color', 'divi-pro-gallery'),
                'type'           => 'color-alpha',
                'default'        => '',
                'custom_color'   => true,
                'mobile_options' => true,
                'tab_slug'    => 'advanced',
                'toggle_slug'    => 'pagination',
                'sub_toggle'      => 'normal',
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'show_pagination' => 'on',
                ],
            ],

            'pagination_text_color' => [
                'label'          => esc_html__('Text Color', 'divi-pro-gallery'),
                'type'           => 'color-alpha',
                'default'        => '',
                'custom_color'   => true,
                'mobile_options' => true,
                'tab_slug'    => 'advanced',
                'toggle_slug'    => 'pagination',
                'sub_toggle'      => 'normal',
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'show_pagination' => 'on',
                ],
            ],

            'pagination_border_color' => [
                'label'          => esc_html__('Border Color', 'divi-pro-gallery'),
                'type'           => 'color-alpha',
                'default'        => '',
                'custom_color'   => true,
                'mobile_options' => true,
                'tab_slug'    => 'advanced',
                'toggle_slug'    => 'pagination',
                'sub_toggle'      => 'normal',
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'show_pagination' => 'on',
                ],
            ],

            'pagination_bg_active' => [
                'label'          => esc_html__('Background Color', 'divi-pro-gallery'),
                'type'           => 'color-alpha',
                'default'        => '',
                'custom_color'   => true,
                'mobile_options' => true,
                'tab_slug'    => 'advanced',
                'toggle_slug'    => 'pagination',
                'sub_toggle'      => 'active',
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'show_pagination' => 'on',
                ],
            ],

            'pagination_text_color_active' => [
                'label'          => esc_html__('Text Color', 'divi-pro-gallery'),
                'type'           => 'color-alpha',
                'default'        => '',
                'custom_color'   => true,
                'mobile_options' => true,
                'tab_slug'    => 'advanced',
                'toggle_slug'    => 'pagination',
                'sub_toggle'      => 'active',
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'show_pagination' => 'on',
                ],
            ],

            'pagination_border_color_active' => [
                'label'          => esc_html__('Border Color', 'divi-pro-gallery'),
                'type'           => 'color-alpha',
                'default'        => '',
                'custom_color'   => true,
                'mobile_options' => true,
                'tab_slug'    => 'advanced',
                'toggle_slug'    => 'pagination',
                'sub_toggle'      => 'active',
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'show_pagination' => 'on',
                ],
            ],

            'pagination_padding' => [
                'label'           => esc_html__('Pager Padding', 'divi-pro-gallery'),
                'type'            => 'custom_margin',
                'option_category' => 'basic_option',
                'mobile_options'  => true,
                'responsive'      => true,
                'default'         => '10px|15px|10px|15px',
                'tab_slug'    => 'advanced',
                'toggle_slug'    => 'pagination',
                'sub_toggle'      => 'normal',
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'show_pagination' => 'on',
                ],
            ],

            'pagination_spacing' => [
                'label'           => esc_html__('Pager Spacing', 'divi-pro-gallery'),
                'type'            => 'text',
                'default'         => '10px',
                'mobile_options'  => true,
                'validate_unit'   => true,
                'option_category' => 'basic_option',
                'tab_slug'    => 'advanced',
                'toggle_slug'    => 'pagination',
                'sub_toggle'      => 'normal',
                'show_if'         => [
                    'gallery_type' => ['grid', 'masonry'],
                    'show_pagination' => 'on',
                ],
            ],

        ];

        $caption = [
            'hide_caption'     => [
                'label'            => esc_html__('Hide Caption', 'divi-pro-gallery'),
                'type'             => 'yes_no_button',
                'options'          => [
                    'on'  => __('yes', 'divi-pro-gallery'),
                    'off' => __('no', 'divi-pro-gallery'),
                ],
                'default'          => 'off',
                'toggle_slug'      => 'caption',
                'computed_affects' => [
                    '__gallery',
                ],
            ],

            'hide_title'       => [
                'label'            => esc_html__('Hide Title', 'divi-pro-gallery'),
                'type'             => 'yes_no_button',
                'options'          => [
                    'on'  => __('yes', 'divi-pro-gallery'),
                    'off' => __('no', 'divi-pro-gallery'),
                ],
                'default'          => 'off',
                'toggle_slug'      => 'caption',
                'computed_affects' => [
                    '__gallery',
                ],
                'show_if'          => [
                    'hide_caption' => 'off',
                ],
            ],

            'hide_description' => [
                'label'            => esc_html__('Hide Description', 'divi-pro-gallery'),
                'type'             => 'yes_no_button',
                'options'          => [
                    'on'  => __('yes', 'divi-pro-gallery'),
                    'off' => __('no', 'divi-pro-gallery'),
                ],
                'default'          => 'on',
                'toggle_slug'      => 'caption',
                'computed_affects' => [
                    '__gallery',
                ],
                'show_if'          => [
                    'hide_caption' => 'off',
                ],
            ],
        ];

        $computed = [
            '__gallery' => [
                'type'                => 'computed',
                'computed_callback'   => ['DPG_Gallery', 'gallery_html'],
                'computed_depends_on' => [
                    'gallery_ids',
                    'gallery_type',
                    'image_size',
                    'columns',
                    'gutter',
                    'highlight_count',
                    'slider_type',
                    'slider_arrows',
                    'slider_height',
                    'slider_speed',
                    'click_action',
                    'lightbox_actions',
                    'hide_filters',
                    'hide_all_filter',
                    'all_filter_label',
                    'hide_caption',
                    'hide_title',
                    'hide_description',
                    'show_pagination',
                    'items_per_page',
                    // 'hover_effects'
                ],
            ],
        ];

        return array_merge(
            $general,
            $overlay,
            $click_action,
            $filters,
            $pagination,
            $caption,
            $computed
        );
    }

    public function get_advanced_fields_config()
    {

        $advanced_fields                 = [];
        $advanced_fields['text']         = [];
        $advanced_fields['text_shadow']  = [];
        $advanced_fields['fonts']        = [];
        $advanced_fields['borders']      = [];
        $advanced_fields['box_shadow']   = [];
        $advanced_fields['link_options'] = [];
        $advanced_fields['button']       = [];

        $advanced_fields['borders']['items'] = array(
            'css'         => [
                'main' => [
                    'border_radii'  => '%%order_class%% .dpg-item',
                    'border_styles' => '%%order_class%% .dpg-item',
                ],
            ],
            'toggle_slug' => 'items',
        );

        $advanced_fields['borders']['normal'] = [
            'label_prefix'        => esc_html__('Filter', 'divi-pro-gallery'),
            'css'                 => [
                'main' => [
                    'border_radii'  => '%%order_class%% .dpg-filters li.dpg-filter-item',
                    'border_styles' => '%%order_class%% .dpg-filters li.dpg-filter-item',
                ],
            ],
            'toggle_slug'         => 'filter_bar',
            'depends_show_if_not' => 'on',
            'depends_on'          => [
                'hide_filters',
            ],
        ];

        $advanced_fields['borders']['active'] = [
            'label_prefix'        => esc_html__('Active', 'divi-pro-gallery'),
            'css'                 => [
                'main' => [
                    'border_radii'  => '%%order_class%% .dpg-filters li.dpg-filter-item.current',
                    'border_styles' => '%%order_class%% .dpg-filters li.dpg-filter-item.current',
                ],
            ],
            'toggle_slug'         => 'filter_bar',
            'depends_show_if_not' => 'on',
            'depends_on'          => [
                'hide_filters',
            ],
        ];

        $advanced_fields['fonts']['caption_title'] = [
            'label'           => esc_html__('Title', 'divi-pro-gallery'),
            'css'             => [
                'main' => "%%order_class%% .dpg-item-content h2",
            ],
            'font_size'       => [
                'default' => '18px',
            ],
            'line_height'     => [
                'default' => '1.2em',
            ],
            'hide_text_align' => true,
            'toggle_slug'     => 'caption_text',
            'sub_toggle'      => 'caption_title',
        ];

        $advanced_fields['fonts']['caption_desc'] = [
            'label'           => esc_html__('Description', 'divi-pro-gallery'),
            'css'             => [
                'main' => "%%order_class%% .dpg-item-content p",
            ],
            'font_size'       => [
                'default' => '14px',
            ],
            'line_height'     => [
                'default' => '1.5em',
            ],
            'hide_text_align' => true,
            'toggle_slug'     => 'caption_text',
            'sub_toggle'      => 'caption_desc',
        ];

        $advanced_fields['fonts']['filter_normal'] = [
            'label'            => esc_html__('Normal', 'divi-pro-gallery'),
            'css'              => [
                'main'        => "%%order_class%% .dpg-filters li, %%order_class%% .dpg-filters ul li a",
                'color'       => "%%order_class%% .dpg-filters ul li a",
                'hover'       => "%%order_class%% .dpg-filters li:hover, %%order_class%% .dpg-filters li:hover a",
                'color_hover' => "%%order_class%% .dpg-filters li:hover a",
                'important'   => 'all',
            ],
            'font_size'        => [
                'default' => '14px',
            ],
            'line_height'      => [
                'default' => '1em',
            ],
            'hide_line_height' => true,
            'toggle_slug'      => 'filters_text',
            'sub_toggle'       => 'normal',
        ];

        $advanced_fields['fonts']['filter_active'] = [
            'label'            => esc_html__('Active', 'divi-pro-gallery'),
            'css'              => [
                'main'        => "%%order_class%% .dpg-filters li.current, %%order_class%% .dpg-filters li.current a",
                'color'       => "%%order_class%% .dpg-filters li.current a",
                'hover'       => "%%order_class%% .dpg-filters li.current:hover, %%order_class%% .dpg-filters li.current:hover a",
                'color_hover' => "%%order_class%% .dpg-filters li.current:hover a",
                'important'   => 'all',
            ],
            'hide_line_height' => true,
            'toggle_slug'      => 'filters_text',
            'sub_toggle'       => 'active',
        ];

        $advanced_fields['borders']['image'] = [
            'label_prefix' => esc_html__('Image', 'divi-pro-gallery'),
            'css'          => [
                'main' => [
                    'border_radii'  => '%%order_class%% .dpg-items .dpg-item img, %%order_class%% .dpg-items .dpg-item .pic',
                    'border_styles' => '%%order_class%% .dpg-items .dpg-item img, %%order_class%% .dpg-items .dpg-item .pic',
                ],
            ],
            'tab_slug'     => 'advanced',
            'toggle_slug'  => 'image',
        ];

        $advanced_fields['filters'] = [
            'css'                  => [
                'main' => '%%order_class%%',
            ],

            'child_filters_target' => [
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'image',
            ],
        ];

        return $advanced_fields;
    }

    static function gallery_html($args = [], $conditional_tags = [], $current_page = [])
    {

        $gallery = new self();

        do_action('dgp_get_gallery_html_before');

        $gallery->props = $args;

        $output = $gallery->gallery_handler([], [], $current_page);

        do_action('dgp_get_gallery_html_after');

        return $output;
    }

    public function gallery_handler($args = [], $conditional_tags = [], $current_page = [])
    {

        foreach ($args as $arg => $value) {
            $this->props[$arg] = $value;
        }

        if (empty($this->props['gallery_ids'])) {
            return sprintf('%s', esc_html__('Gallery not found.', 'divi-pro-gallery'));
        }

        $gallery_type = $this->props['gallery_type'];

        $gallery_items = get_posts([
            'include'        => $this->props['gallery_ids'],
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => 'ASC',
            'orderby'        => 'post__in',
        ]);

        if (empty($gallery_items)) {
            return sprintf('%s', esc_html__('Gallery not found.', 'divi-pro-gallery'));
        }

        // Gallery items.
        ob_start();

        if ('highlight' === $gallery_type) {
            $highlight_count = 0;
        }

        $items = 1;

        foreach ($gallery_items as $image) {

            if ('highlight' === $gallery_type) {
                $highlight_count++;
            }

            $image_object = get_post($image->ID);
            $thumb        = wp_get_attachment_image_src($image->ID, 'thumbnail');
            $image_full   = wp_get_attachment_image_src($image->ID, 'full');
            $image_src    = wp_get_attachment_image_src($image->ID, $this->props['image_size']);

            // Image data.
            $image_data = [
                'id'              => $image->ID,
                'title'           => $image_object->post_title,
                'description'     => $image_object->post_content,
                'caption'         => wp_get_attachment_caption($image->ID),
                'item_attributes' => [],
                'link_attributes' => [],
                'img_attributes'  => [
                    'alt'              => wp_get_attachment_caption($image->ID),
                    'title'            => $image->post_title,
                    'data-description' => $image->post_conten,
                    'data-caption'     => $image->caption,
                    'data-full'        => esc_url($image->guid),
                ],
                'img_classes'     => ['image', 'pic', 'wp-image-' . $image->ID],
                'link_classes'    => ['dpg-item-link'],
                'item_classes'    => ['dpg-item'],
                'click_action'    => $this->props['click_action'],
            ];

            if ('grid' === $gallery_type) {
                $image_data['img_classes'][] = 'dpg-square';
            }

            if ('highlight' === $gallery_type) {

                if ($highlight_count === 1) {
                    $image_data['item_classes'][] = 'dpg-item-highlight';
                }

                if (($highlight_count % intval($this->props['highlight_count'])) === 0) {
                    $image_data['item_classes'][] = 'dpg-item-highlight';
                }
            }

            if ('slider' === $gallery_type) {
                $image_data['item_classes'][] = 'splide__slide';
            }

            if ($thumb) {
                $image_data['img_attributes']['data-thumb'] = esc_url($thumb[0]);
            }

            if ($image_full) {
                $image_data['image_full'] = esc_url($image_full[0]);
            }

            if ($image_src) {
                $image_data['image_src']                  = esc_url($image_src[0]);
                $image_data['img_attributes']['src']      = (isset($image_src[0])) ? $image_src[0] : $image_full[0];
                $image_data['img_attributes']['data-src'] = (isset($image_src[0])) ? $image_src[0] : $image_full[0];
            }

            if ('no-link' !== $this->props['click_action']) {

                if ('file' === $this->props['click_action']) {
                    $image_data['link_attributes']['href'] = $image_full ? esc_url($image_full[0]) : esc_url($image_src[0]);
                }

                if ('attachment' === $this->props['click_action']) {
                    $image_data['link_attributes']['href'] = get_attachment_link($image->ID);
                }

                if ('custom' === $this->props['click_action']) {
                    $image_data['link_attributes']['href'] =  get_post_meta($image->ID, 'gallery_links', true);
                }

                if ('lightbox' === $this->props['click_action']) {
                    $image_data['link_attributes']['href']       = $image_full ? esc_url($image_full[0]) : esc_url($image_src[0]);
                    $image_data['link_attributes']['class'][]    = 'dpg-lightbox-link';
                    $image_data['link_attributes']['aria-label'] = esc_html__('Open image', 'divi-pro-gallery');
                    $image_data['link_attributes']['title']      = esc_html__('Open image', 'divi-pro-gallery');

                    // Enable lightbox.
                    $image_data['link_attributes']['data-fancybox'] = 'dpg-gallery';
                }
            }

            $has_filters = ('off' === $this->props['hide_filters']) && ('grid' === $gallery_type || 'masonry' === $gallery_type) ? true : false;

            $filters_options = [
                'has_filters'      => $has_filters,
                'hide_all_filter'  => 'on' === $this->props['hide_all_filter'] ? false : true,
                'all_filter_label' => $this->props['all_filter_label'],

            ];

            $filters_data['options'] = $filters_options;

            if ($has_filters) {
                $filters = get_post_meta($image->ID, 'gallery_tags', true);
                if ($filters) {
                    $filters = explode(',', $filters);
                    foreach ($filters as $filter) {

                        $filter                                = trim($filter);
                        $filter_slug                           = strtolower(str_replace(' ', '-', $filter));
                        $image_data['item_classes'][]          = sanitize_title($filter_slug);
                        $filters_data['filters'][$filter_slug] = $filter;
                    }
                }
            }

            $has_pagination = ('on' === $this->props['show_pagination']) && ('grid' === $gallery_type || 'masonry' === $gallery_type) ? true : false;

            if ($has_pagination && $items <= $this->props['items_per_page']) {
                $image_data['item_classes'][] = 'dpg-item-visible';
            }

            // $image_data['item_classes'][] = 'dpg-item-' . $this->props['hover_effects'];

            include DPG_PATH . 'includes/views/item.php';

            $items++;
        }

        // Output: Gallery.
        if ('slider' === $gallery_type) {

            $gallery = sprintf(
                '
                <div class="%s">
                    <div class="%s">%s</div>
                </div>',
                "splide__track",
                "splide__list dpg-items",
                ob_get_clean()
            );
        } else {

            $gallery = sprintf(
                '
                <div class="%s">%s</div>',
                "dpg-items",
                ob_get_clean()
            );
        }

        // Filters.
        ob_start();
        $filters = '';

        if ($has_filters) {
            include DPG_PATH . 'includes/views/filters.php';
            $filters = sprintf('<div class="%s">%s</div>', "dpg-filters", ob_get_clean());
        }

        ob_start();
        $pagination = '';

        if ($has_pagination) {
            include DPG_PATH . 'includes/views/pagination.php';
            $pagination = sprintf('<div class="dpg-pagination-wrap">%s</div>', ob_get_clean());
        }

        return wp_kses_post($filters . $gallery . $pagination);
    }

    public function render($attrs, $content, $render_slug)
    {

        $gallery_type = $this->props['gallery_type'];
        $click_action = $this->props['click_action'];
        $actions      = $this->props['lightbox_actions'];
        $has_filters  = ('off' === $this->props['hide_filters']) && ('grid' === $gallery_type || 'masonry' === $gallery_type) ? true : false;
        $has_pagination  = ('on' === $this->props['show_pagination']) && ('grid' === $gallery_type || 'masonry' === $gallery_type) ? true : false;
        $hasLightbox  = false;
        $lightboxOpts = ['close'];

        if ('lightbox' === $click_action) {

            $actions     = explode('|', $actions);
            $action_name = [
                'zoom',
                'share',
                'slideShow',
                'fullScreen',
                'download',
                'thumbs',
            ];

            foreach ($actions as $i => $action) {
                if (!$action || 'off' === $action) {
                    continue;
                }
                $lightboxOpts[] = $action_name[$i];
            }

            $hasLightbox = true;
        }

        $columns = Helper::get_responsive_options('columns', $this->props);


        $order_class   = self::get_module_order_class($render_slug);
        $order_number  = str_replace('_', '', str_replace($this->slug, '', $order_class));

        $data_config = [
            'type'              => $gallery_type,
            'order_id'          => $order_number,
            'lightbox'          => $hasLightbox,
            'lightboxOpts'      => $lightboxOpts,
            'hasFilters'        => $has_filters,
            'hasPagination'     => $has_pagination,
            'items_per_page'    => $this->props['items_per_page'],
            'columnsResponsive' => $columns['responsive_status'],
            'columns'           => absint($columns['desktop']),
            'columnsTablet'     => absint($columns['tablet']),
            'columnsPhone'      => absint($columns['phone']),
            'gutter'            => absint($this->props['gutter']),
        ];

        if ('slider' === $gallery_type) {
            $data_config['slider'] = [
                'slider_type'   => $this->props['slider_type'],
                'slider_speed'  => absint($this->props['slider_speed']),
                'slider_height' => $this->props['slider_height'],
                'slider_arrows' => 'on' === $this->props['slider_arrows'] ? true : false,
            ];
        }

        $gallery_attr = [
            'class'       => ['divi-pro-gallery', "dpg-$gallery_type"],
            'data-config' => wp_json_encode($data_config),
        ];

        if ('slider' === $gallery_type) {
            $gallery_attr['class'][] = 'splide';
        }

        if ('slider' === $gallery_type) {
            $gallery_attr['class'][] = 'dpg-splide-' . $order_number;
        }


        // Gallery output.
        $output = sprintf(
            '<div %2$s>
                %1$s
            </div>',
            $this->gallery_handler(),
            Helper::render_attributes($gallery_attr)
        );

        // Enqueue frontend scripts.
        wp_enqueue_script('dpg-frontend');
        wp_enqueue_style('dpg-frontend');

        // Generate css.
        $this->generate_css($render_slug);

        // Return output.
        return $output;
    }

    public function generate_css($render_slug)
    {

        $gutter                = $this->props['gutter'] ? intval($this->props['gutter']) : 20;
        $arrow_size            = $this->props['arrow_size'] ? intval($this->props['arrow_size']) : 32;
        $columns               = Helper::get_responsive_options('columns', $this->props);
        $filter_alignment      = Helper::get_responsive_options('filter_alignment', $this->props);
        $filter_spacing        = Helper::get_responsive_options('filter_spacing', $this->props);
        $filter_spacing_bottom = Helper::get_responsive_options('filter_spacing_bottom', $this->props);

        if ($this->props['filter_padding']) {
            $value                         = explode('|', $this->props['filter_padding']);
            $this->props['filter_padding'] = ($value[0] ? $value[0] : 0) . ' ' . ($value[1] ? $value[1] : 0) . ' ' . ($value[2] ? $value[2] : 0) . ' ' . ($value[3] ? $value[3] : 0);
        }

        ET_Builder_Element::set_style(
            $render_slug,
            [
                'selector'    => '%%order_class%% .divi-pro-gallery:not(.dpg-highlight):not(.dpg-slider) .dpg-item',
                'declaration' => "width: calc((100% - {$gutter}px * ( {$columns['desktop']} - 1 )) / {$columns['desktop']});",
            ]
        );

        if ($columns['responsive_status']) {
            ET_Builder_Element::set_style(
                $render_slug,
                [
                    'selector'    => '%%order_class%% .divi-pro-gallery:not(.dpg-highlight):not(.dpg-slider) .dpg-item',
                    'declaration' => "width: calc((100% - {$gutter}px * ( {$columns['tablet']} - 1 )) / {$columns['tablet']});",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ]
            );

            ET_Builder_Element::set_style(
                $render_slug,
                [
                    'selector'    => '%%order_class%% .divi-pro-gallery:not(.dpg-highlight):not(.dpg-slider) .dpg-item',
                    'declaration' => "width: calc((100% - {$gutter}px * ( {$columns['phone']} - 1 )) / {$columns['phone']});",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ]
            );
        }

        $this->generate_styles(
            [
                'hover'          => false,
                'base_attr_name' => 'overlay_bg_color',
                'selector'       => '%%order_class%% .dpg-item:hover .dpg-item-overlay',
                'css_property'   => ['background-color'],
                'important'      => true,
                'render_slug'    => $render_slug,
                'type'           => 'color',
            ]
        );


        $this->generate_styles(
            [
                'hover'          => false,
                'base_attr_name' => 'overlay_bg_opacity',
                'selector'       => '%%order_class%% .dpg-item:hover .dpg-item-content img.pic',
                'css_property'   => ['opacity'],
                'important'      => true,
                'render_slug'    => $render_slug,
                'type'           => 'color',
            ]
        );

        // Filters
        ET_Builder_Element::set_style(
            $render_slug,
            [
                'selector'    => 'div%%order_class%% .dpg-filters',
                'declaration' => "margin-right: {$filter_spacing_bottom['desktop']};",
            ]
        );

        if ($filter_spacing_bottom['responsive_status']) {
            ET_Builder_Element::set_style(
                $render_slug,
                [
                    'selector'    => 'div%%order_class%% .dpg-filters',
                    'declaration' => "margin-right: {$filter_spacing_bottom['tablet']};",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ]
            );

            ET_Builder_Element::set_style(
                $render_slug,
                [
                    'selector'    => 'div%%order_class%% .dpg-filters',
                    'declaration' => "margin-right: {$filter_spacing_bottom['phone']};",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ]
            );
        }

        ET_Builder_Element::set_style(
            $render_slug,
            [
                'selector'    => '%%order_class%% .dpg-filters ul.dpg-filters-list',
                'declaration' => "justify-content: {$filter_alignment['desktop']};",
            ]
        );

        if ($filter_alignment['responsive_status']) {
            ET_Builder_Element::set_style(
                $render_slug,
                [
                    'selector'    => 'div%%order_class%% .dpg-filters ul.dpg-filters-list',
                    'declaration' => "justify-content:  {$filter_alignment['tablet']};",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ]
            );

            ET_Builder_Element::set_style(
                $render_slug,
                [
                    'selector'    => 'div%%order_class%% .dpg-filters ul.dpg-filters-list',
                    'declaration' => "justify-content: {$filter_alignment['phone']};",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ]
            );
        }

        ET_Builder_Element::set_style(
            $render_slug,
            [
                'selector'    => 'div%%order_class%% .dpg-filters li:not(:last-child)',
                'declaration' => "margin-right: {$filter_spacing['desktop']};",
            ]
        );

        if ($filter_spacing['responsive_status']) {
            ET_Builder_Element::set_style(
                $render_slug,
                [
                    'selector'    => 'div%%order_class%% .dpg-filters li:not(:last-child)',
                    'declaration' => "margin-right: {$filter_spacing['tablet']};",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ]
            );

            ET_Builder_Element::set_style(
                $render_slug,
                [
                    'selector'    => 'div%%order_class%% .dpg-filters li:not(:last-child)',
                    'declaration' => "margin-right: {$filter_spacing['phone']};",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ]
            );
        }

        $this->generate_styles(
            [
                'hover'          => false,
                'base_attr_name' => 'filter_padding',
                'selector'       => 'div%%order_class%% .dpg-filters ul li a',
                'css_property'   => 'padding',
                'render_slug'    => $render_slug,
                'type'           => 'custom_margin',
            ]
        );

        $this->generate_styles(
            [
                'hover'          => false,
                'base_attr_name' => 'filter_bg',
                'selector'       => 'div%%order_class%% .dpg-filters ul li a',
                'css_property'   => ['background-color'],
                'important'      => true,
                'render_slug'    => $render_slug,
                'type'           => 'color',
            ]
        );

        $this->generate_styles(
            [
                'hover'          => false,
                'base_attr_name' => 'filter_bg_active',
                'selector'       => 'div%%order_class%% .dpg-filters ul li.current a',
                'css_property'   => ['background-color'],
                'important'      => true,
                'render_slug'    => $render_slug,
                'type'           => 'color',
            ]
        );

        // Slider.
        $arrow_icon_size = absint($arrow_size) / 1.6;

        $this->generate_styles(
            [
                'hover'          => false,
                'base_attr_name' => 'arrow_color',
                'selector'       => '%%order_class%% .splide__arrow svg',
                'css_property'   => ['fill'],
                'render_slug'    => $render_slug,
                'type'           => 'color',
                'important'      => true,
            ]
        );

        $this->generate_styles(
            [
                'hover'          => false,
                'base_attr_name' => 'arrow_bg_color',
                'selector'       => '%%order_class%% .splide__arrow',
                'css_property'   => ['background'],
                'render_slug'    => $render_slug,
                'type'           => 'color',
                'important'      => true,
            ]
        );

        ET_Builder_Element::set_style(
            $render_slug,
            [
                'selector'    => '%%order_class%% .splide__arrow',
                'declaration' => sprintf('width: %spx; height: %spx;', $arrow_size, $arrow_size),
            ]
        );

        ET_Builder_Element::set_style(
            $render_slug,
            [
                'selector'    => '%%order_class%% .splide__arrow svg',
                'declaration' => sprintf('width: %spx; height: %spx;', $arrow_icon_size, $arrow_icon_size),
            ]
        );

        // Pagination
        $this->generate_styles(
            [
                'hover'          => false,
                'base_attr_name' => 'pagination_alignment',
                'selector'       => '%%order_class%% .dpg-pagination-wrap > div',
                'css_property'   => ['justify-content'],
                'render_slug'    => $render_slug,
                'important'      => true,
            ]
        );


        $this->generate_styles(
            [
                'hover'          => true,
                'base_attr_name' => 'pagination_bg',
                'selector'       => 'div%%order_class%% .dpg-pagination-wrap > div a',
                'css_property'   => ['background'],
                'render_slug'    => $render_slug,
                'type'           => 'color',
                'important'      => true,
            ]
        );

        $this->generate_styles(
            [
                'hover'          => true,
                'base_attr_name' => 'pagination_text_color',
                'selector'       => 'div%%order_class%% .dpg-pagination-wrap > div a',
                'css_property'   => ['color'],
                'render_slug'    => $render_slug,
                'type'           => 'color',
                'important'      => true,
            ]
        );

        $this->generate_styles(
            [
                'hover'          => true,
                'base_attr_name' => 'pagination_border_color',
                'selector'       => 'div%%order_class%% .dpg-pagination-wrap > div a',
                'css_property'   => ['border-color'],
                'render_slug'    => $render_slug,
                'type'           => 'color',
                'important'      => true,
            ]
        );

        $this->generate_styles(
            [
                'hover'          => true,
                'base_attr_name' => 'pagination_bg_active',
                'selector'       => 'div%%order_class%% .dpg-pagination-wrap > div a.current',
                'css_property'   => ['background'],
                'render_slug'    => $render_slug,
                'type'           => 'color',
                'important'      => true,
            ]
        );

        $this->generate_styles(
            [
                'hover'          => true,
                'base_attr_name' => 'pagination_text_color_active',
                'selector'       => 'div%%order_class%% .dpg-pagination-wrap > div a.current',
                'css_property'   => ['color'],
                'render_slug'    => $render_slug,
                'type'           => 'color',
                'important'      => true,
            ]
        );

        $this->generate_styles(
            [
                'hover'          => true,
                'base_attr_name' => 'pagination_border_color_active',
                'selector'       => 'div%%order_class%% .dpg-pagination-wrap > div a.current',
                'css_property'   => ['border-color'],
                'render_slug'    => $render_slug,
                'type'           => 'color',
                'important'      => true,
            ]
        );

        if ($this->props['pagination_padding']) {
            $value                         = explode('|', $this->props['pagination_padding']);
            $this->props['pagination_padding'] = ($value[0] ? $value[0] : 0) . ' ' . ($value[1] ? $value[1] : 0) . ' ' . ($value[2] ? $value[2] : 0) . ' ' . ($value[3] ? $value[3] : 0);
        }


        $this->generate_styles(
            [
                'hover'          => false,
                'base_attr_name' => 'pagination_padding',
                'selector'       => 'div%%order_class%% .dpg-pagination-wrap > div > a',
                'css_property'   => 'padding',
                'render_slug'    => $render_slug,
                'type'           => 'custom_margin',
                'important'      => true,
            ]
        );

        $this->generate_styles(
            [
                'hover'          => false,
                'base_attr_name' => 'pagination_spacing',
                'selector'       => 'div%%order_class%% .dpg-pagination-wrap > div',
                'css_property'   => 'gap',
                'render_slug'    => $render_slug,
            ]
        );
    }

    public function multi_view_filter_value($raw_value, $args)
    {

        $name = isset($args['name']) ? $args['name'] : '';
        if ($raw_value && 'font_icon' === $name) {
            return et_pb_get_extended_font_icon_value($raw_value, true);
        }

        return $raw_value;
    }
}

new DPG_Gallery();
