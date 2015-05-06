<?php


class CacheTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        //Create test cache file to use and insert my birthday as timestamp 827366400
        file_put_contents('cache/'.CACHE_FILE.'.php', '<!-- 827366400 -->');
    }

    protected function _after()
    {
        unlink('cache/'.CACHE_FILE.'.php');
    }

    public function testTimestamp()
    {
        $timestamp = Cache::getTimestamp(CACHE_FILE);
        $this->assertEquals('827366400', $timestamp);
    }

    /**
     * @expectedException Exception
     */
    public function testMissingCacheTimestamp()
    {
        $timestamp = Cache::getTimestamp(NON_CACHE_FILE);
    }

    public function testCacheExists()
    {
        //Make sure the existant file returns true
        $cacheExists = Cache::cacheExists(CACHE_FILE);
        $this->assertTrue($cacheExists);
    }

    public function testCacheDoesntExist()
    {
        //Make sure that non-existant file returns false
        $cacheExists = Cache::cacheExists(NON_CACHE_FILE);
        $this->assertFalse($cacheExists);
    }
}