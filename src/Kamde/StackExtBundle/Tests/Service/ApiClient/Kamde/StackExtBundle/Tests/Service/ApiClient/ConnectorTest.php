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
        $this->connector->setSite('MySite.com');
    }

    /**
     * @test
     */
    public function should_send_valid_get_request()
    {
        $method = 'GET';
        $uri = 'test.org';

        $input = [
            'foo' => 1,
            'bar' => 'baz'
        ];

        $output = [
            'baz' => 'zoz'
        ];

        $this->clientMock
            ->expects(self::once())
            ->method('request')
            ->with($method, $uri . '?foo=1&bar=baz&site=MySite.com', []);

        $this->responseMock
            ->expects(self::once())
            ->method('getBody')
            ->willReturn(json_encode($output));

        $response = $this->connector->getResponse($method, $uri, $input);

        $this->assertEquals($output, $response);
    }

    /**
     * @test
     * @dataProvider provideMethod
     * @param string $method
     */
    public function should_send_valid_post_request(string $method)
    {
        $uri = 'test.org';

        $input = [
            'foo' => 1,
            'bar' => 'baz'
        ];

        $output = [
            'baz' => 'zoz'
        ];

        $this->clientMock
            ->expects(self::once())
            ->method('request')
            ->with($method, $uri, array_merge($input, ['site' => 'MySite.com']));

        $this->responseMock
            ->expects(self::once())
            ->method('getBody')
            ->willReturn(json_encode($output));

        $response = $this->connector->getResponse($method, $uri, $input);

        $this->assertEquals($output, $response);
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
