<?php

namespace Kamde\StackExtBundle\Tests\Service\Connector;

use Kamde\StackExtBundle\Service\Connector\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function should_build_post_request_with_valid_parameters()
    {
        $method = 'POST';
        $uri = 'mysite.com';
        $parameters = [
            'foo' => 'bar'
        ];

        $request = new Request($method, $uri, $parameters);

        $request->setParameters(['bar' => 'baz']);
        $request->setParameter('abc', 123);

        $this->assertEquals([
            'bar' => 'baz',
            'abc' => 123
        ], $request->getParameters());

        $this->assertEquals('mysite.com', $request->getUri());
    }

    /**
     * @test
     */
    public function should_build_get_request_with_valid_uri()
    {
        $method = 'GET';
        $uri = 'mysite.com';
        $parameters = [
            'foo' => 'bar'
        ];

        $request = new Request($method, $uri, $parameters);

        $request->setParameters(['bar' => 'baz']);
        $request->setParameter('abc', 123);
        $request->setParameter('xyz', '');

        $this->assertEquals([], $request->getParameters());
        $this->assertEquals('mysite.com?bar=baz&abc=123&xyz=', $request->getUri());
    }
}
