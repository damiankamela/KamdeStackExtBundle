<?php

namespace Kamde\StackExtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KamdeStackExtBundle:Default:index.html.twig');
    }
}
