<?php

namespace Kamde\StackExtBundle\Tests\Service\ApiClient\Connector;

use GuzzleHttp\ClientInterface;
use Kamde\StackExtBundle\Service\ApiClient\Connector\Connector;
use Kamde\StackExtBundle\Service\ApiClient\Request;
use Kamde\StackExtBundle\Service\ApiClient\ResponseInterface;
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

        $this->connector = new Connector($this->clientMock, 'MySite.com');
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
            ->with($method, $uri . '?foo=1&bar=baz&site=MySite.com', []);

        $this->responseMock
            ->expects(self::once())
            ->method('getBody')
            ->willReturn(json_encode($output));

        $request = new Request($method, $uri, $input);
        $response = $this->connector->getResponse($request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals([['baz' => 'zoz']], $response->getItems());
        $this->assertEquals(100, $response->getQuotaMax());
        $this->assertEquals(99, $response->getQuotaRemaining());
        $this->assertfalse($response->hasMore());
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
            ->with($method, $uri, array_merge($input, ['site' => 'MySite.com']));

        $this->responseMock
            ->expects(self::once())
            ->method('getBody')
            ->willReturn(json_encode($output));

        $request = new Request($method, $uri, $input);
        $response = $this->connector->getResponse($request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals([['baz' => 'zoz']], $response->getItems());
        $this->assertEquals(100, $response->getQuotaMax());
        $this->assertEquals(99, $response->getQuotaRemaining());
        $this->assertfalse($response->hasMore());
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
