<?php

namespace WPVuePlugin;

class Settings
{
    protected $option_key = 'wpvueplugin_settings';

    protected $options = array();

    public function __construct($options = array())
    {
        foreach ($options as $key => $value) {
            $this->add_option($key, $value['name'], $value['value'], $value['type'], $value['desc']);
        }
    }

    public function add_option($key, $name = '', $value = '', $type = 'text', $desc = '')
    {
        $this->options[$key] = [
            'name' => $name,
            'value' => $value,
            'type' => $type,
            'desc' => $desc,
        ];
    }

    public function get_options()
    {
        $options = $this->options;

        if (!get_option($this->option_key)) {
            $data = array();

            foreach ($options as $key => $value) {
                $data[$key] = $value['value'];
            }

            update_option($this->option_key, $data);
        } else {
            $saved = get_option($this->option_key);

            foreach ($options as $key => $value) {
                if ($saved[$key]) {
                    $options[$key]['value'] = $saved[$key];
                }
            }
        }

        return $options;
    }

    public function get_option($key)
    {
        return $this->options[$key];
    }

    public function get_option_key()
    {
        return $this->option_key;
    }
}
