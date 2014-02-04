<?php

namespace App\Framework;

class Configuration
{
    protected $data = [];

    public function __construct($data)
    {
        foreach ($data as $key => $value) {


            $this->set($key, $value);
        }
    }

    public function set($key, $value)
    {
        $lowerKey = strtolower($key);

        $this->data[$lowerKey] = $value;

        return $this;
    }

    public function get($key)
    {
        $lowerKey = strtolower($key);

        if (!isset($this->data[$lowerKey])) {
            throw new \OutOfBoundsException(sprintf('"%s" is not a valid configuration item', $lowerKey));
        }

        return $this->data[$lowerKey];
    }
}

