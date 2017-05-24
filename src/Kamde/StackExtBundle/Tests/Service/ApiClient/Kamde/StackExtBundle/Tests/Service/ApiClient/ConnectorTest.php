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
     * @dataProvider provideData
     * @param $uri
     * @param $input
     * @param $output
     */
    public function should_send_valid_get_request($uri, $input, $output)
    {
        $method = 'GET';

        $this->clientMock->expects(self::once())->method('request')->with($method, $uri . '?foo=1&bar=baz');
        $this->responseMock->expects(self::once())->method('getBody')->willReturn(json_encode($output));

        $response = $this->connector->getResponse($method, $uri, $input);

        $this->assertEquals($output, $response);
    }

    /**
     * @test
     * @dataProvider provideData
     * @param $uri
     * @param $input
     * @param $output
     */
    public function should_send_valid_post_request($uri, $input, $output)
    {
        $method = 'POST';

        $this->clientMock->expects(self::once())->method('request')->with($method, $uri, $input);
        $this->responseMock->expects(self::once())->method('getBody')->willReturn(json_encode($output));

        $response = $this->connector->getResponse($method, $uri, $input);

        $this->assertEquals($output, $response);
    }

    public function provideData()
    {
        return [
            [
                ['my_url'],
                ['foo' => 1, 'bar' => 'baz'],
                ['baz' => 'zoz']
            ]
        ];
    }
}
