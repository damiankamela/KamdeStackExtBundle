<?php

namespace Kamde\StackExtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function testAction()
    {
        $connector = $this->get('kamde_stack_ext.connector');

        $connector->test();

        dump("Test");
        die;
    }

}