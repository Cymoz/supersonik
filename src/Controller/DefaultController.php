<?php

namespace App\Controller;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $members = $em->getRepository('App:Member')->findAll();
        /**@var \App\Entity\Member $member */


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

    public function page(Request $request, EntityManagerInterface $em, $slug){
        $tabLocales = $this->getParameter("locales");
        $tabTmp = explode("/", $slug);
        if(in_array($tabTmp[0], $tabLocales)){
            /*unset($tabTmp[0]);
            $slug = implode("/", $tabTmp);*/
            $slug = substr($slug, 3, strlen($slug));
        }

        /**
         * @var $page Page
         */
        $page = $em->getRepository("App:Page")->getOneBySlug($slug);

        if(!$page){
            throw new NotFoundHttpException("404",null,404);
        }

        $template = $page->getTemplate() ?: 'page/default.html.twig';

        $context['page'] = $page;

        return $this->render($template, $context);
    }
}
