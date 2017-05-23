<?php

namespace Kamde\StackExtBundle\Tests\Service\ApiClient;

use GuzzleHttp\ClientInterface;
use Kamde\StackExtBundle\Service\ApiClient\Connector;
use PHPUnit_Framework_MockObject_MockObject as Mock;
use Psr\Http\Message\MessageInterface;

class ConnectorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Connector */
    protected $connector;

    /** @var ClientInterface|Mock */
    protected $clientMock;

    /** @var MessageInterface|Mock */
    protected $responseMock;

    public function setUp()
    {
        $this->clientMock = $this->getMockBuilder(ClientInterface::class)->getMock();
        $this->responseMock = $this->getMockBuilder(MessageInterface::class)->getMock();

        $this->clientMock->expects(self::any())->method('request')->willReturn($this->responseMock);

        $this->connector = new Connector($this->clientMock);
    }

    /**
     * @test
     */
    public function shouldSomething()
    {
        $json = json_encode(['foo' => 'bar']);

        $this->responseMock->expects(self::once())->method('getBody')->willReturn($json);

        $response = $this->connector->test();

        $this->assertEquals(['foo' => 'bar'], $response);
    }
}
