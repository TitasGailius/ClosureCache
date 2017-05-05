<?php

namespace ClosureCache;

class ClosureCache
{
    /**
     * The current globally available container (if any).
     *
     * @var static
     */
    protected static $instance;

    /**
     * Cached closure results.
     *
     * @var array
     */
    protected $cache = [];

    /**
     * Set the globally available instance of the container.
     *
     * @return static
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Helper method to return cached closure result.
     *
     * @param  Closure $closure
     * @return mixed
     */
    public static function remember($closure)
    {
        return static::instance()->cache($closure);
    }

    /**
     * Caches closure and returns it's result.
     *
     * @param  Closure $closure
     * @return mixed
     */
    protected function cache($closure)
    {
        $key = $this->generateKey($closure);

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = $closure();
        }

        return $this->cache[$key];
    }

    /**
     * Generates unique identifier for the closure.
     *
     * @param  Closure $closure
     * @return string
     */
    protected function generateKey($closure)
    {
        $reflection = new \ReflectionFunction($closure);

        return md5(serialize([
            $reflection->getFileName(),
            $reflection->getStartLine(),
            $reflection->getEndLine(),
            $reflection->getStaticVariables(),
        ]));
    }
}
