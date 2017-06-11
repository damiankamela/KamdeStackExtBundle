<?php

namespace Kamde\StackExtBundle\Tests\Service\Resource;

use Kamde\StackExtBundle\Service\Resource\ResourceNormalizer;

class ResourceNormalizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function should_normalize_array_to_object()
    {
        $normalizer = new ResourceNormalizer();

        $data = [
            'property_1' => 'bar',
            'second_property' => 'baz'
        ];

        $foo = $normalizer->normalize(Foo::class, $data);

        $this->assertEquals('bar', $foo->getProperty1());
        $this->assertEquals('baz', $foo->getSecondProperty());
    }
}

class Foo
{
    protected $property1;

    protected $secondProperty;

    public function getProperty1()
    {
        return $this->property1;
    }

    public function setProperty1($property1)
    {
        $this->property1 = $property1;
    }

    public function getSecondProperty()
    {
        return $this->secondProperty;
    }

    public function setSecondProperty($secondProperty)
    {
        $this->secondProperty = $secondProperty;
    }
}
