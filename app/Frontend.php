<?php

namespace WPVuePlugin;

class Frontend
{
    public function __construct()
    {
        add_shortcode('wpvueplugin-frontend-app', [$this, 'render_frontend']);
    }

    public function render_frontend($atts, $content = '')
    {
        wp_enqueue_style('wpvueplugin-frontend');
        wp_enqueue_script('wpvueplugin-frontend');

        $object = array(
            'page_title' => 'WP Vue Plugin Frontend',
        );

        wp_localize_script('wpvueplugin-frontend', 'wpvueplugin_object', $object);

        return '<div id="wpvueplugin-frontend-app"></div>';
    }
}
