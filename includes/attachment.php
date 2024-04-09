<?php

namespace Divi_Pro_Gallery\Includes;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

class Attachment
{
    public function __construct()
    {
        add_filter('attachment_fields_to_edit', [$this, 'custom_fields_edit'], 10, 2);
        add_filter('attachment_fields_to_save', [$this, 'custom_fields_save'], 10, 2);
    }

    public function custom_fields_edit($form_fields, $post)
    {
        $form_fields['gallery_tags'] = array(
            'label' => sprintf(__('%1s - Tags (Ex: Branding, Print)', 'divi-pro-gallery'), 'Pro Gallery'),
            'input' => 'text',
            'value' => get_post_meta($post->ID, 'gallery_tags', true),
        );

        $form_fields['gallery_links'] = array(
            'label' => sprintf(__('%1s - Link', 'divi-pro-gallery'), 'Pro Gallery'),
            'input' => 'text',
            'value' => get_post_meta($post->ID, 'gallery_links', true),
        );

        return $form_fields;
    }

    public function custom_fields_save($post, $attachment)
    {
        if (isset($attachment['gallery_tags'])) {
            update_post_meta($post['ID'], 'gallery_tags', $attachment['gallery_tags']);
        }

        if (isset($attachment['gallery_links'])) {
            update_post_meta($post['ID'], 'gallery_links', $attachment['gallery_links']);
        }

        return $post;
    }
}
