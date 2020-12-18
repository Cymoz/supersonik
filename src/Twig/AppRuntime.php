<?php

namespace App\Twig;

use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;
use App\Service\WidgetManager;

class AppRuntime implements RuntimeExtensionInterface
{
    protected $entityManager;
    protected $routingExtension;
    protected $twig;
    protected $widgetManager;
    protected $repository;

    public function __construct(EntityManagerInterface $entityManager, RouterInterface $routingExtension, Environment $twig, WidgetManager $widgetManager, PageRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->routingExtension = $routingExtension;
        $this->twig = $twig;
        $this->widgetManager = $widgetManager;
        $this->repository = $repository;
    }
    
    public function widget($content)
    {
       
        $content = $this->widgetManager->applyWidgets($content);

        return $content;

    }

    public function pageUrl($context, $alias)
    {
        //dd($this->repository);
        /**@var $page **/

        //$page = $this->repository->findOneBy(['alias'=>$alias]);
        $page = $this->entityManager->getRepository('App:Page')->findOneBy(['alias'=>$alias]);
        if (!$page){
            return "#".$alias;
        }

        $locale = $context['app']->getRequest()->getLocale();

        return $this->routingExtension->generate('page', array('_locale'=>$locale, 'slug'=>$page->getSlug()));
    }
}

