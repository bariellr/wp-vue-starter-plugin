<?php

namespace WPVuePlugin;

use WPVuePlugin\Api\SettingsApi;

class Api
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes()
    {
        (new SettingsApi())->register_routes();
    }
}
