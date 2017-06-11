<?php

namespace Kamde\StackExtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function testAction()
    {
        dump("Test");
        die;
    }

}