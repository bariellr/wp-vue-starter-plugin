<?php

namespace WPVuePlugin\Api;

use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Server;

class SettingsApi extends WP_REST_Controller
{
    protected $namespace = 'wpvueplugin-api/v1';

    public function __construct()
    {
        // 
    }

    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            'settings',
            array(
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => array($this, 'save_options'),
            )
        );
    }

    public function save_options(WP_REST_Request $request)
    {
        $postData = $request->get_json_params();

        $data = array();

        foreach ($postData as $key => $value) {
            $data[$key] = sanitize_text_field($value);
        }

        update_option(\WPVuePlugin::init()->settings->get_option_key(), $data);

        return rest_ensure_response($data);
    }
}
