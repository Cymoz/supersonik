<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function index(): Response
    {

        $context =[
            'controller_name' => 'DefaultController'
        ];
        return $this->render('default/index.html.twig', $context);
    }

    public function page2(): Response
    {

        $context =[
            'controller_name' => 'DefaultController'
        ];
        return $this->render('default/secondPage.html.twig', $context);
    }
}