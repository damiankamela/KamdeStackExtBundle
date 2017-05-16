<?php

namespace Kamde\StackExtBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('Welcome to KamdeStackExtBundle!', $client->getResponse()->getContent());
    }
}
