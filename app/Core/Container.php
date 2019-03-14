<?php

namespace App\Core;

/**
 * Class Container
 * @package App
 *
 */
class Container implements \ArrayAccess
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var array
     */
    protected $cache = [];

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param $offset
     * @return bool
     */
    public function has($offset): bool
    {
        return $this->offsetExists($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            return null;
        }

        if (!isset($this->cache[$offset])) {
            $this->cache[$offset] = $this->items[$offset]($this);
        }

        return $this->cache[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->offsetExists($name);
    }
}
