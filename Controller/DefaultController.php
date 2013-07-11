<?php

namespace Oxygen\DatagridBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OxygenDatagridBundle:Default:index.html.twig', array('name' => $name));
    }
}
