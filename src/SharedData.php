<?php

namespace Coderello\SharedData;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
use JsonSerializable;

class SharedData implements Renderable, Jsonable
{
    private $data = [];

    private $jsNamespace = 'sharedData';

    public function __construct(array $config = [])
    {
        $this->hydrateConfig($config);
    }

    private function hydrateConfig(array $config)
    {
        if (isset($config['js_namespace'])) {
            $this->setJsNamespace($config['js_namespace']);
        }
    }

    public function put($key, $value = null)
    {
        if (is_scalar($key)) {
            Arr::set($this->data, $key, $value);
        } elseif (is_iterable($key)) {
            foreach ($key as $nestedKey => $nestedValue) {
                $this->put($nestedKey, $nestedValue);
            }
        } elseif ($key instanceof JsonSerializable) {
            $this->put($key->jsonSerialize());
        } elseif ($key instanceof Arrayable) {
            $this->put($key->toArray());
        } elseif (is_object($key)) {
            $this->put(get_object_vars($key));
        } else {
            throw new InvalidArgumentException('Key type ['.gettype($key).'] is not supported.');
        }

        return $this;
    }

    public function get($key = null)
    {
        if (is_null($key)) {
            return $this->data;
        }

        return Arr::get($this->data, $key);
    }

    public function getJsNamespace(): string
    {
        return $this->jsNamespace;
    }

    public function setJsNamespace(string $jsNamespace): self
    {
        $this->jsNamespace = $jsNamespace;

        return $this;
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->get(), $options);
    }

    public function render(): string
    {
        return '<script>window[\''.$this->getJsNamespace().'\'] = '.$this->toJson().';</script>';
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
