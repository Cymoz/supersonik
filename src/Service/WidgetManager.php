<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class WidgetManager
{
    private $entityManager;
    private $twig;

    public function __construc(EntityManagerInterface $entityManager, Environment $twig)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    public function applyWidgets($content)
    {
        $pattern = '#\[[^\]]*\]#';
        preg_match_all($pattern, $content, $out);

        var_dump($out);

        foreach ($out[0] as $widget) 
        {
            // widget = [members limit = 2 start =1]
            $widget = str_replace(array('[',']'), '', $widget);
            // widget = members limit = 2 start =1
            //find method
            $tabWidget = explode("", $widget);
            // tabWidget[0] = members
            // tabWidget[1] = limit=2
            // tabWidget[2] = start=1

            $method = 'widget' . ucfirst($tabWidget);
            // $method = widgetMembers
            array_shift($tabWidget);
            // tabWidgets[0]
            // tabWidgets[1]

            // create params array
            $tabParams = [];
            foreach ($tabWidget as $params)
            {
                // 0 limit=2
                $tmpParams = explode('=', $params);
                // tmpParams[0] = limit
                // tmpParams[1] = 2
                $tabParams[$tmpParams[0] = $tmpParams[1]];
            }

            $content = $this->$method($tabWidget, $content);
        }
        return $content;
    }

    private function widgetMembers($tabParams, $content, $name = 'members')
    {

        $limit = isset($tabParams['limit']) ? $tabParams['limit'] : 3;

        $members = $this->entityManager->getRepository('App:Member')->findBy([],[],$limit);

        $context = ['members'=> $members];

        $widget_members = $this->twig->render('widget/members.html.twig',$context);

        $content = str_replace(array('['.$name,']'), array($widget_members,''), $content);
        
        return $content;

    }
}

?>