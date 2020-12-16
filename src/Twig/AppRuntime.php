<?php


namespace App\Twig;


use App\Manager\WidgetManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    protected $em;
    protected $routingExtension;
    protected $twig;
    private $widgetManager;

    public function __construct(EntityManagerInterface $entityManager, RouterInterface $routingExtension, Environment $twig, WidgetManager $widgetManager)
    {
        $this->em = $entityManager;
        $this->routingExtension = $routingExtension;
        $this->twig = $twig;
        $this->widgetManager = $widgetManager;
    }

    public function widget($content)
    {
        $content = $this->widgetManager->applyWidgets($content);
        return $content;
    }

    public function pageUrl($context, $alias): string
    {
        $page = $this->em->getRepository('App:Page')->findOneBy(['alias' => $alias]);

        if (!$page) {
            return "#" . $alias;
        }

        $locale = $context['app']->getRequest()->getLocale();

        return $this->routingExtension->generate('page', ['_locale' => $locale, 'slug' => $page->getSlug()]);
    }
}