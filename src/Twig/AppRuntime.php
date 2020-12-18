<?php

namespace App\Twig;

use App\Service\WidgetManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    protected $em;
    protected $rountingExtension;
    protected $twig;
    protected $widgetManager;

    public function __construct(EntityManagerInterface $entityManager, RouterInterface $rountingExtension, Environment $twig, WidgetManager $widgetManager)
    {
        $this->em = $entityManager;
        $this->rountingExtension = $rountingExtension;
        $this->twig = $twig;
        $this->widgetManager = $widgetManager;
    }

    public function widget($content) 
    {
        $content = $this->widgetManager->applyWidgets($content);

        return $content;
    }

    public function pageUrl($context, $alias)
    {
        /** @var $page Page **/
        $page = $this->em->getRepository('App:Page')->findOneBy(['alias'=>$alias]);

        if (!$page) {
            return "#".$alias;
        }

        $locale = $context['app']->getRequest()->getLocale();

        return $this->rountingExtension->generate('page',array('_locale'=>$locale, 'slug' => $page->getSlug()));
    }
}