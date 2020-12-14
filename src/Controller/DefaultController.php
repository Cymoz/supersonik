<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $members = $em->getRepository('App:Member')->findAll();

        $context = [
            'controller_name' => 'DefaultController',
            'members' => $members
        ];

        return $this->render('default/index.html.twig', $context);
    }

    public function contact(): Response
    {
        $context = [
            'contact' => 'contact',
        ];
        return $this->render('default/contact.html.twig', $context);
    }
}
