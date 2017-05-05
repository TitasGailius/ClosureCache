<?php

namespace ClosureCache\Tests;

use ClosureCache\ClosureCache;
use PHPUnit_Framework_TestCase;

class ClosureCacheTest extends PHPUnit_Framework_TestCase
{
    public function test_that_it_caches_items()
    {
        $firstCall = $this->getUniqueId();
        $secondCall = $this->getUniqueId();

        $this->assertEquals($firstCall, $secondCall);
    }

    public function test_that_cache_handles_different_parameters()
    {
        $firstCall = $this->getUniqueId('prefix1');
        $secondCall = $this->getUniqueId('prefix2');
        $thirdCall = $this->getUniqueId('prefix1');

        $this->assertEquals($firstCall, $thirdCall);
        $this->assertNotEquals($firstCall, $secondCall);
    }

    /**
     * Returns cached uniqid
     *
     * @param  string|null $prefix
     * @return string
     */
    public function getUniqueId($prefix = null)
    {
        return ClosureCache::remember(function () use ($prefix) {
            return uniqid($prefix);
        });
    }
}
