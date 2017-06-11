<?php

namespace Kamde\StackExtBundle\Tests\Service\Serialization;

use Kamde\StackExtBundle\Service\Serialization\PropertyNameConverter;

class PropertyNameConverterTest extends \PHPUnit_Framework_TestCase
{
    /** @var PropertyNameConverter */
    protected $converter;

    public function setUp()
    {
        $serializedClass = 'Foo\User';
        $this->converter = new PropertyNameConverter($serializedClass);
    }

    /**
     * @test
     */
    public function should_return_denormalized_property_name()
    {
        $this->assertEquals('id', $this->converter->denormalize('user_id'));
        $this->assertEquals('name', $this->converter->denormalize('name'));
    }

    /**
     * @test
     */
    public function should_return_normalized_property_name()
    {
        $this->assertEquals('user_id', $this->converter->normalize('id'));
        $this->assertEquals('user_name', $this->converter->normalize('name'));
    }
}
