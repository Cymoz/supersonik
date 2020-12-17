<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class WidgetManager
{

    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager){

        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    public function applyWidgets($content){

        $pattern = '#\[(.+)\]#';
        preg_match_all($pattern,$content, $out);

        foreach($out[1] as $widget){

            //$widget = str_replace(array('[',']'), '', $widget);

            $tabWidget = explode(" ",$widget);

            $method = 'widget'. ucfirst($tabWidget[0]);

            array_shift($tabWidget);

            $tabParams = [];
            foreach($tabWidget as $params){

                $tmpParams = explode('=',$params);
                $tabParams[$tmpParams[0]] = $tmpParams[1];

            }

            $content = $this->$method($widget, $tabParams, $content);
        }

        return $content;
    }

    private function widgetMembers($widget,$tabParams, $content){

        $limit = isset($tabParams['limit']) ? $tabParams['limit'] : null;

        $members = $this->entityManager->getRepository('App:Member')->findBy([],[],$limit);

        $context = ['members'=> $members];

        $widget_members = $this->twig->render('widget/members.html.twig',$context);

        $content = str_replace(array('[',$widget,']'), array('',$widget_members,''), $content);


        return $content;

    }

}