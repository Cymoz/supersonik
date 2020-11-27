<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
<<<<<<< HEAD

    public function index(): Response
    {
        $em = $this -> getDoctrine() -> getManager(); // Pré-requis dès traitement DATA
        $members = $em -> getRepository('App:Member') -> findAll();
=======
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $members = $em->getRepository('App:Member')->findAll();
>>>>>>> 446e837a159d156f34b837c03fe571a31b856b39

        $context = [
            'controller_name' => 'DefaultController',
            'members' => $members
        ];

        return $this->render('default/index.html.twig', $context);
    }

<<<<<<< HEAD
    public function page2(): Response
    {
        $context = [
            'controller_name' => 'DefaultController'
        ];

        return $this -> render('default/page2.html.twig', $context);
    }
=======
    public function contact(): Response
    {
        $context = [
            'contact' => 'contact',
        ];
        return $this->render('default/contact.html.twig', $context);
    }


>>>>>>> 446e837a159d156f34b837c03fe571a31b856b39
}
