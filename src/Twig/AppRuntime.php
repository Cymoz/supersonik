<?php


namespace App\Twig;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    protected $em;
    protected $routingExtension;

    public function __construct(EntityManagerInterface $entityManager, RouterInterface $routingExtension)
    {
        $this->em = $entityManager;
        $this->routingExtension = $routingExtension;
    }

    public function pageUrl($context, $alias){
        $page = $this->em->getRepository('App:Page')->findOneBy(['alias'=>$alias]);

        if(!$page){
            return "#".$alias;
        }

        $locale = $context['app']->getRequest()->getLocale();

        return $this->routingExtension->generate('page', ['_locale'=>$locale, 'slug' => $page->getSlug()]);
    }
}