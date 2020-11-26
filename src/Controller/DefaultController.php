<?php

namespace App\Controller;

use App\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $members = $entityManager->getRepository(Member::class)->findAll();
        $context = 
            [
                'controller_name' => 'DefaultController',
                'members' => $members
            ];
        return $this->render('default/index.html.twig', $context);
    }

    public function page(): Response
    {
        $context = 
            [
                'new_page' => 'Nouvelle page',
            ];
        return $this->render('page/index.html.twig', $context);
    }
}
