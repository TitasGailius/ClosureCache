<?php
/*
 * Helper function to cache a closure
 *
 * @param  Closure $closure
 * @return mixed
 */
if (!function_exists('once')) {

    function once($closure)
    {
        return \ClosureCache\ClosureCache::remember($closure);
    }
}
