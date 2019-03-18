<?php

namespace Coderello\SharedData;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;
use LogicException;

class SharedData implements Renderable, Jsonable
{
    protected $data = [];

    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function put($key, $value = null)
    {
        if (is_scalar($key)) {
            Arr::set($this->data, $key, $value);
        } elseif (is_iterable($key)) {
            foreach ($key as $nestedKey => $nestedValue) {
                $this->put($nestedKey, $nestedValue);
            }
        } elseif (is_object($key)) {
            $this->put(get_object_vars($key));
        } else {
            throw new \InvalidArgumentException();
        }

        return $this;
    }

    public function get($key = null)
    {
        if (is_null($key)) {
            return $this->data;
        } else {
            return Arr::get($this->data, $key);
        }
    }

    protected function getNamespace()
    {
        if (! ($namespace = Arr::get($this->config, 'js_namespace'))) {
            throw new LogicException('JavaScript namespace should be specified in the config file.');
        }

        return $namespace;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->get(), $options);
    }

    public function render()
    {
        return '<script>window[\''.$this->getNamespace().'\'] = '.$this->toJson().';</script>';
    }
}
