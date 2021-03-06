<?php

namespace Kamde\StackExtBundle\Tests\Service\Resource;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Kamde\StackExtBundle\Service\Connector\StackConnector;
use Kamde\StackExtBundle\Service\Connector\Request;
use Kamde\StackExtBundle\Service\Resource\AbstractResource;
use PHPUnit_Framework_MockObject_MockObject as Mock;

class AbstractResourceTest extends \PHPUnit_Framework_TestCase
{
    /** @var AbstractResource|Mock|mixed */
    protected $resource;

    /** @var StackConnector|Mock */
    protected $connectorMock;

    public function setUp()
    {
        $this->connectorMock = $this
            ->getMockBuilder(StackConnector::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resource = $this
            ->getMockBuilder(AbstractResource::class)
            ->setConstructorArgs([$this->connectorMock, 1])
            ->setMethods(['getResourceName'])
            ->getMockForAbstractClass();

        $this->resource->expects(self::any())->method('getResourceName')->willReturn('Users');
    }

    /**
     * @test
     * @expectedException \Kamde\StackExtBundle\Service\Exception\MethodNotFoundException
     */
    public function calling_invalid_method_should_throw_error()
    {
        $this->resource->foo();
    }

    /**
     * @test
     * @expectedException \Kamde\StackExtBundle\Service\Exception\InvalidMethodCallException
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
            ->with(new Request('GET', 'users/1/foo-bar'))
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
            ->with(new Request('GET', 'users/1/'))
            ->willReturn(['foo']);

        $response = $this->resource->getData();

        $this->assertEquals(['foo'], $response);
    }

    /**
     * @test
     */
    public function should_retrieve_resource_quota_with_arguments()
    {
        $this->connectorMock
            ->expects(self::once())
            ->method('getResponse')
            ->with(new Request('GET', 'users/1/foo/bar/baz'))
            ->willReturn(['foo']);

        $response = $this->resource->getFoo('bar', 'baz');

        $this->assertEquals(['foo'], $response);
    }
}
