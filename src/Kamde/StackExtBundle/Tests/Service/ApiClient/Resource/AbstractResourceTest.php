<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Resource;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Kamde\StackExtBundle\Service\ApiClient\Connector;
use PHPUnit_Framework_MockObject_MockObject as Mock;

class AbstractResourceTest extends \PHPUnit_Framework_TestCase
{
    /** @var AbstractResource */
    protected $resource;

    /** @var Connector|Mock */
    protected $connectorMock;

    public function setUp()
    {
        $this->connectorMock = $this->getMockBuilder(Connector::class)->disableOriginalConstructor()->getMock();

        $this->resource = $this->getMockBuilder(AbstractResource::class)
            ->setConstructorArgs([$this->connectorMock])->getMockForAbstractClass();
    }

    /**
     * @test
     * @expectedException \Kamde\StackExtBundle\Service\ApiClient\Exception\ResourceNotSetException
     */
    public function not_set_id_should_throw_error()
    {
        $this->resource->getSomething();
    }

    /**
     * @test
     * @expectedException \Kamde\StackExtBundle\Service\ApiClient\Exception\MethodNotFoundException
     */
    public function calling_invalid_method_should_throw_error()
    {
        $this->resource->setId(1);

        $this->resource->foo();
    }

    /**
     * @test
     * @expectedException \Kamde\StackExtBundle\Service\ApiClient\Exception\MethodNotFoundException
     */
    public function calling_unavailable_resource_should_throw_error()
    {
        $this->resource->setId(1);

        $this->connectorMock
            ->expects(self::once())
            ->method('getResponse')
            ->willThrowException(new RequestException('foo', new Request('GET', 'foo')));

        $this->resource->getSomething();
    }

    /**
     * @test
     */
    public function should_retrieve_resource_quota()
    {
        $this->resource->setId(1);

        $this->connectorMock
            ->expects(self::once())
            ->method('getResponse')
            ->with('GET', 's/1/foo-bar')
            ->willReturn(['foo' => 'bar']);

        $response = $this->resource->getFooBar();

        $this->assertEquals(['foo' => 'bar'], $response);
    }

    /**
     * @test
     */
    public function should_retrieve_resource_data()
    {
        $this->resource->setId(1);

        $this->connectorMock
            ->expects(self::once())
            ->method('getResponse')
            ->with('GET', 's/1/')
            ->willReturn(['foo' => 'bar']);

        $response = $this->resource->getData();

        $this->assertEquals(['foo' => 'bar'], $response);
    }
}
