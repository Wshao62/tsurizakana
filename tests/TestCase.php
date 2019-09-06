<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * プロテクテッド、プライベートなメソッドを呼び出す
     *
     * @param $object
     * @param $method_name
     * @param array $arguments
     * @return mixed
     */
    public function callMethod($object, $method_name, array $arguments = [])
    {
        $class = new \ReflectionClass($object);
        $method = $class->getMethod($method_name);
        $method->setAccessible(true);
        return empty($arguments)
        ? $method->invoke($object)
        : $method->invokeArgs($object, $arguments);
    }

    /**
     * プロテクテッド、プライベートなプロパティを返却
     *
     * @param $object
     * @param $property_name
     * @return mixed
     */
    public static function getPrivateProperty($object, $property_name)
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($property_name);
        $property->setAccessible(true);
        return $property->getValue($object);
    }
}
