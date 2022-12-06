<?php

namespace WPVuePlugin;

class Admin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    public function admin_menu()
    {
        global $submenu;

        $capability = 'manage_options';
        $slug = 'wpvueplugin-admin-app';

        $hook = add_menu_page(
            __('WP Vue Plugin', 'wpvueplugin'),
            __('WP Vue Plugin', 'wpvueplugin'),
            $capability,
            $slug,
            [$this, 'plugin_page'],
            'dashicons-cart'
        );

        if (current_user_can($capability)) {
            $submenu[$slug][] = array(
                __('Settings', 'wpvueplugin'),
                $capability,
                'admin.php?page=' . $slug . '#/'
            );

            $submenu[$slug][] = array(
                __('About', 'wpvueplugin'),
                $capability,
                'admin.php?page=' . $slug . '#/about'
            );
        }

        add_action('load-' . $hook, [$this, 'init_hooks']);
    }

    public function init_hooks()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('wpvueplugin-admin');
        wp_enqueue_script('wpvueplugin-admin');

        $object = array(
            'page_title' => 'WP Vue Plugin Settings',
            'options' => \WPVuePlugin::init()->settings->get_options(),
            'settings_endpoint' => get_rest_url(null, 'wpvueplugin-api/v1') . '/settings',
        );

        wp_localize_script('wpvueplugin-admin', 'wpvueplugin_object', $object);
    }

    public function plugin_page()
    {
        echo '<div class="wrap"><div id="wpvueplugin-admin-app"></div></div>';
    }
}
