<?php

namespace Kamde\StackExtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function testAction()
    {
        $resourceFactory = $this->get('kamde_stack_ext.resource_factory');
        $resource = $resourceFactory->createUserResource(5929417);

        dump($resource->getData());
        die;
    }

}