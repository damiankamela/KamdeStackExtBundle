<?php

namespace Kamde\StackExtBundle\Tests\Service\ApiClient\Resource;

use Kamde\StackExtBundle\Service\ApiClient\Connector\StackConnector;
use Kamde\StackExtBundle\Service\ApiClient\Resource\ResourceFactory;
use Kamde\StackExtBundle\Service\ApiClient\Resource\UserResource;
use \PHPUnit_Framework_MockObject_MockObject as Mock;

class ResourceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ResourceFactory|mixed */
    protected $factory;

    public function setUp()
    {
        $this->factory = new ResourceFactory($this->getConnectorMock());
    }

    /**
     * @test
     */
    public function should_create_resource()
    {
        $id = 1;
        $resource = $this->factory->createUserResource($id);

        $this->assertInstanceOf(UserResource::class, $resource);
        $this->assertEquals(1, $resource->getId());
    }

    /**
     * @test
     * @expectedException \Kamde\StackExtBundle\Service\ApiClient\Exception\ResourceNotFoundException
     */
    public function try_create_unknown_resource()
    {
        $this->factory->createFooResource(1);
    }

    /**
     * @test
     * @expectedException \Kamde\StackExtBundle\Service\ApiClient\Exception\MethodNotFoundException
     */
    public function try_call_undefined_method()
    {
        $this->factory->doFooResource(1);
    }

    /**
     * @return StackConnector|Mock
     */
    protected function getConnectorMock()
    {
        return $this->getMockBuilder(StackConnector::class)->disableOriginalConstructor()->getMock();
    }
}
