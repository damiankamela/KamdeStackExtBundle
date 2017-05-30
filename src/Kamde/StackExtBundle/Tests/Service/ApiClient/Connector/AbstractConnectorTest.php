<?php

namespace Kamde\StackExtBundle\Tests\Service\ApiClient\Connector;

use GuzzleHttp\ClientInterface;
use Kamde\StackExtBundle\Service\ApiClient\Connector\AbstractConnector;
use Kamde\StackExtBundle\Service\ApiClient\Connector\Request;
use PHPUnit_Framework_MockObject_MockObject as Mock;
use Psr\Http\Message\MessageInterface;

class AbstractConnectorTest extends \PHPUnit_Framework_TestCase
{
    /** @var AbstractConnector|Mock */
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

        $this->connector = $this
            ->getMockBuilder(AbstractConnector::class)
            ->setConstructorArgs([$this->clientMock])
            ->getMockForAbstractClass();
    }

    /**
     * @test
     */
    public function send_get_request()
    {
        $method = 'GET';
        $uri = 'test.org';

        $input = [
            'foo' => 1,
            'bar' => 'baz'
        ];

        $output = [
            'quotaMax'       => 100,
            'quotaRemaining' => 99,
            'hasMore'        => false,
            'items'          => [
                ['baz' => 'zoz']
            ],
        ];

        $this->clientMock
            ->expects(self::once())
            ->method('request')
            ->with($method, $uri . '?foo=1&bar=baz', []);

        $this->responseMock
            ->expects(self::once())
            ->method('getBody')
            ->willReturn(json_encode($output));

        $this->connector->expects(self::once())->method('buildResponse')->willReturn(['foo']);

        $request = new Request($method, $uri, $input);
        $response = $this->connector->getResponse($request);

        $this->assertEquals(['foo'], $response);
    }

    /**
     * @test
     * @dataProvider provideMethod
     * @param string $method
     */
    public function send_other_request(string $method)
    {
        $uri = 'test.org';

        $input = [
            'foo' => 1,
            'bar' => 'baz'
        ];

        $output = [
            'quotaMax'       => 100,
            'quotaRemaining' => 99,
            'hasMore'        => false,
            'items'          => [
                ['baz' => 'zoz']
            ],
        ];

        $this->clientMock
            ->expects(self::once())
            ->method('request')
            ->with($method, $uri, $input);

        $this->responseMock
            ->expects(self::once())
            ->method('getBody')
            ->willReturn(json_encode($output));

        $this->connector->expects(self::once())->method('buildResponse')->willReturn(['foo']);

        $request = new Request($method, $uri, $input);
        $response = $this->connector->getResponse($request);

        $this->assertEquals(['foo'], $response);
    }

    public function provideMethod()
    {
        return [
            ['POST'],
            ['PATCH'],
            ['DELETE']
        ];
    }
}
