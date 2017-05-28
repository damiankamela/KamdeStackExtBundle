<?php

namespace Kamde\StackExtBundle\Tests\Service\ApiClient\Resource;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Kamde\StackExtBundle\Service\ApiClient\Connector\Connector;
use Kamde\StackExtBundle\Service\ApiClient\Request;
use Kamde\StackExtBundle\Service\ApiClient\Resource\AbstractResource;
use Kamde\StackExtBundle\Service\ApiClient\ResponseInterface;
use PHPUnit_Framework_MockObject_MockObject as Mock;

class AbstractResourceTest extends \PHPUnit_Framework_TestCase
{
    /** @var AbstractResource|mixed */
    protected $resource;

    /** @var Connector|Mock */
    protected $connectorMock;

    public function setUp()
    {
        $this->connectorMock = $this
            ->getMockBuilder(Connector::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resource = $this
            ->getMockBuilder(AbstractResource::class)
            ->setConstructorArgs([$this->connectorMock, 1])
            ->getMockForAbstractClass();
    }

    /**
     * @test
     * @expectedException \Kamde\StackExtBundle\Service\ApiClient\Exception\MethodNotFoundException
     */
    public function calling_invalid_method_should_throw_error()
    {
        $this->resource->foo();
    }

    /**
     * @test
     * @expectedException \Kamde\StackExtBundle\Service\ApiClient\Exception\MethodNotFoundException
     */
    public function calling_unavailable_resource_should_throw_error()
    {
        $this->connectorMock
            ->expects(self::once())
            ->method('getResponse')
            ->willThrowException(new RequestException('foo', new GuzzleRequest('GET', 'foo')));

        $this->resource->getSomething();
    }

    /**
     * @test
     */
    public function should_retrieve_resource_quota()
    {
        $this->connectorMock
            ->expects(self::once())
            ->method('getResponse')
            ->with(new Request('GET', 's/1/foo-bar'))
            ->willReturn(['foo']);

        $response = $this->resource->getFooBar();

        $this->assertEquals(['foo'], $response);
    }

    /**
     * @test
     */
    public function should_retrieve_resource_data()
    {
        $this->connectorMock
            ->expects(self::once())
            ->method('getResponse')
            ->with(new Request('GET', 's/1/'))
            ->willReturn(['foo']);

        $response = $this->resource->getData();

        $this->assertEquals(['foo'], $response);
    }
}
