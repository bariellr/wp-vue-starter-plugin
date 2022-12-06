<?php
/*
Plugin Name: WP Vue Plugin
Plugin URI: 
Description: 
Version: 0.1.0
Author: 
Author URI: 
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: testplugin
Domain Path: /languages
*/

if (!defined('ABSPATH')) exit;

final class WPVuePlugin
{
    public $version = '0.1.0';

    private $container = array();

    public function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        add_action('plugins_loaded', array($this, 'init_plugin'));
    }

    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new WPVuePlugin();
        }

        return $instance;
    }

    public function __get($prop)
    {
        if (array_key_exists($prop, $this->container)) {
            return $this->container[$prop];
        }

        return $this->{$prop};
    }

    public function __isset($prop)
    {
        return isset($this->{$prop}) || isset($this->container[$prop]);
    }

    public function define_constants()
    {
        define('WPVUEPLUGIN_VERSION', $this->version);
        define('WPVUEPLUGIN_FILE', __FILE__);
        define('WPVUEPLUGIN_PATH', dirname(WPVUEPLUGIN_FILE));
        define('WPVUEPLUGIN_INCLUDES', WPVUEPLUGIN_PATH . '/includes');
        define('WPVUEPLUGIN_URL', plugins_url('', WPVUEPLUGIN_FILE));
        define('WPVUEPLUGIN_ASSETS', WPVUEPLUGIN_URL . '/public');
    }

    public function init_plugin()
    {
        $this->includes();
        $this->init_hooks();
    }

    public function activate()
    {
        $installed = get_option('wpvueplugin_installed');

        if (!$installed) {
            update_option('wpvueplugin_installed', time());
        }

        update_option('wpvueplugin_version', WPVUEPLUGIN_VERSION);
    }

    public function deactivate()
    {
    }

    public function includes()
    {
        $autoload = WPVUEPLUGIN_PATH . '/vendor/autoload.php';

        if (file_exists($autoload)) {
            require_once $autoload;
        }
    }

    public function init_hooks()
    {
        add_action('init', array($this, 'init_classes'));
        add_action('init', array($this, 'localization_setup'));
    }

    public function init_classes()
    {
        $this->container['settings'] = new WPVuePlugin\Settings($this->define_settings());

        $this->container['assets'] = new WPVuePlugin\Assets();

        $this->container['api'] = new WPVuePlugin\Api();

        if ($this->is_request('admin')) {
            $this->container['admin'] = new WPVuePlugin\Admin();
        }

        if ($this->is_request('frontend')) {
            $this->container['frontend'] = new WPVuePlugin\Frontend();
        }
    }

    public function define_settings()
    {
        return array(
            'test_option' => array(
                'name' => 'Test Option',
                'value' => '',
                'type' => 'text',
                'desc' => 'A sample option.'
            ),
        );
    }

    public function localization_setup()
    {
        load_plugin_textdomain('wpvueplugin', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    private function is_request($type)
    {
        switch ($type) {
            case 'admin':
                return is_admin();

            case 'ajax':
                return defined('DOING_AJAX');

            case 'rest':
                return defined('REST_REQUEST');

            case 'cron':
                return defined('DOING_CRON');

            case 'frontend':
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
        }
    }
}

$wpvueplugin = WPVuePlugin::init();
