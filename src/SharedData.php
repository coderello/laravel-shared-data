<?php

namespace Coderello\SharedData;

use ArrayAccess;
use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
use JsonSerializable;

class SharedData implements Renderable, Jsonable, Arrayable, JsonSerializable, ArrayAccess
{
    /** @var array */
    private $data = [];

    /** @var string */
    private $jsNamespace = 'sharedData';

    /** @var Closure[]|array */
    private $delayedClosures = [];

    /** @var Closure[]|array */
    private $delayedClosuresWithKeys = [];

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

    private function unpackDelayedClosures(): self
    {
        foreach ($this->delayedClosures as $delayedClosure) {
            $this->put($delayedClosure());
        }

        $this->delayedClosures = [];

        foreach ($this->delayedClosuresWithKeys as $key => $delayedClosure) {
            $this->put($key, $delayedClosure());
        }

        $this->delayedClosuresWithKeys = [];

        return $this;
    }

    public function put($key, $value = null)
    {
        if (is_scalar($key) && $value instanceof Closure) {
            $this->delayedClosuresWithKeys[$key] = $value;
        } elseif (is_scalar($key)) {
            Arr::set($this->data, $key, $value);
        } elseif (is_iterable($key)) {
            foreach ($key as $nestedKey => $nestedValue) {
                $this->put($nestedKey, $nestedValue);
            }
        } elseif ($key instanceof JsonSerializable) {
            $this->put($key->jsonSerialize());
        } elseif ($key instanceof Arrayable) {
            $this->put($key->toArray());
        } elseif ($key instanceof Closure) {
            $this->delayedClosures[] = $key;
        } elseif (is_object($key)) {
            $this->put(get_object_vars($key));
        } else {
            throw new InvalidArgumentException('Key type ['.gettype($key).'] is not supported.');
        }

        return $this;
    }

    public function get($key = null)
    {
        $this->unpackDelayedClosures();

        if (is_null($key)) {
            return $this->data;
        }

        return Arr::get($this->data, $key);
    }

    public function forget($key = null): self
    {
        $this->unpackDelayedClosures();

        if (is_null($key)) {
            $this->data = [];
        } else {
            Arr::forget($this->data, $key);
        }

        return $this;
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
        return '<script>window[\''.$this->getJsNamespace().'\']='.$this->toJson().';window[\'sharedDataNamespace\']=\''.$this->getJsNamespace().'\';</script>';
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function toArray(): array
    {
        return $this->get();
    }

    public function jsonSerialize(): array
    {
        return $this->get();
    }

    public function offsetExists($offset): bool
    {
        return Arr::has($this->data, $offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->put($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->forget($offset);
    }
}
