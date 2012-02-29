<?php

namespace Prodeko\IlmoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('ProdekoIlmoBundle:Default:index.html.twig', array('name' => $name));
    }
}
