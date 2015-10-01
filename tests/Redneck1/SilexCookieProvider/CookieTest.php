<?php
namespace Redneck1\Tests\SilexCookieProvider;

use Silex\Application;
use Redneck1\SilexCookieProvider\SilexCookieProvider;
use Redneck1\SilexCookieProvider\Cookie;

class CookieTest extends \PHPUnit_Framework_TestCase
{
    protected function createMockDefaultApp()
    {
        $app = new Application();
        $app->register(new SilexCookieProvider());

        return $app;
    }

    public function testGet()
    {
        $app = $this->createMockDefaultApp();
        $cookie = $app['cookie']->get('test');
        $this->assertEquals(gettype($cookie), 'string');
    }

    public function testSet()
    {
        $app = $this->createMockDefaultApp();

        try {
            $result = $app['cookie']->set('test', 'testValue');
        }

        catch (\LogicException $expected) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testHas()
    {
        $app = $this->createMockDefaultApp();
        $key = 'someKey';

        $result = $app['cookie']->has($key);
        $this->assertEquals(gettype($result), 'boolean');
    }

    public function testRemove()
    {
        $app = $this->createMockDefaultApp();
        $key = 'someKey';

        $result = $app['cookie']->remove($key);
        $this->assertEquals(gettype($result), 'boolean');
    }

    public function testGetAll()
    {
        $app = $this->createMockDefaultApp();

        $result = $app['cookie']->getAll();
        $this->assertEquals(gettype($result), 'array');
    }
}