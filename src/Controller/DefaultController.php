<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    public function page(Request $request, $slug, EntityManagerInterface $em)
    {
        $tabLocales = $this->getParameter('locales');

        $tabTmp = explode("/", $slug);

        if(in_array($tabTmp[0], $tabLocales))
        {
            $slug = substr($slug, 3, strlen($slug));
        }

        $page = $em->getRepository('App:Page')->getOneBySlug(['slug'=>$slug]);

        if (!$page){
            throw new NotFoundHttpException('404', null, 404);
        }

        dd($page->getTitle());
    }


}
