<?php

namespace WPVuePlugin;

class Assets
{
    public function __construct()
    {
        if (is_admin()) {
            add_action('admin_enqueue_scripts', [$this, 'register'], 5);
        } else {
            add_action('wp_enqueue_scripts', [$this, 'register'], 5);
        }
    }

    public function register()
    {
        $this->register_scripts($this->get_scripts());
        $this->register_styles($this->get_styles());
    }

    private function register_scripts($scripts)
    {
        foreach ($scripts as $handle => $script) {
            $deps = isset($script['deps']) ? $script['deps'] : false;
            $in_footer = isset($script['in_footer']) ? $script['in_footer'] : false;
            $version = isset($script['version']) ? $script['version'] : WPVUEPLUGIN_VERSION;

            wp_register_script($handle, $script['src'], $deps, $version, $in_footer);
        }
    }

    public function register_styles($styles)
    {
        foreach ($styles as $handle => $style) {
            $deps = isset($style['deps']) ? $style['deps'] : false;

            wp_register_style($handle, $style['src'], $deps, WPVUEPLUGIN_VERSION);
        }
    }

    public function get_scripts()
    {
        $scripts = array(
            'wpvueplugin-frontend' => array(
                'src' => WPVUEPLUGIN_ASSETS . '/frontend/main.js',
                'deps' => array('jquery'),
                'version' => filemtime(WPVUEPLUGIN_PATH . '/public/frontend/main.js'),
                'in_footer' => true
            ),
            'wpvueplugin-admin' => array(
                'src' => WPVUEPLUGIN_ASSETS . '/admin/main.js',
                'deps' => array('jquery'),
                'version' => filemtime(WPVUEPLUGIN_PATH . '/public/admin/main.js'),
                'in_footer' => true
            ),
        );

        return $scripts;
    }

    public function get_styles()
    {
        $styles = array(
            'wpvueplugin-frontend' => array(
                'src' => WPVUEPLUGIN_ASSETS . '/frontend/main.css'
            ),
            'wpvueplugin-admin' => array(
                'src' => WPVUEPLUGIN_ASSETS . '/admin/main.css'
            ),
        );

        return $styles;
    }
}
