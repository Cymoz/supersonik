<?php
namespace App\Twig;

use App\Service\WidgetManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class ApppRuntime implements RuntimeExtensionInterface
{
    protected $em;
    protected $routingExtension;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var WidgetManager
     */
    private $widgetManager;

    public function __construct(EntityManagerInterface $em, RouterInterface $routingExtension, Environment $twig, WidgetManager $widgetManager){
        $this->em = $em;
        $this->routingExtension = $routingExtension;
        $this->twig = $twig;
        $this->widgetManager = $widgetManager;
    }

    public function pageUrl($context, $alias){

        $page = $this->em->getRepository('App:Page')->findOneBy(["alias" => $alias]);
        if(!$page){
            return "#".$alias;
        }

        $locale = $context['app']->getRequest()->getLocale();

        return $this->routingExtension->generate('page', ['_locale' => $locale, 'slug' => $page->getSlug()]);
    }

    public function widget($content){

        $content = $this->widgetManager->applyWidgets($content);
        return $content;
    }
}