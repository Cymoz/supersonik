<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function page($slug, EntityManagerInterface $entityManager)
    {

        $tabLocales = $this->getParameter('locales');

        $tabTmp = explode("/", $slug);

        if (in_array($tabTmp[0], $tabLocales)) {
            unset($tabTmp[0]);
            $slug = implode("/", $tabTmp);

        }

        $page = $entityManager->getRepository('App:Page')->getOneBySlug($slug);


        if (!$page) {
            throw new NotFoundHttpException('404', null, 404);
        }

        dd($page->getTitle());
    }
}
