<?php


namespace App\Manager;


use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class WidgetManager
{
    private $entityManager;
    private $twig;

    public function __construct(EntityManagerInterface $entityManager, Environment $twig)
    {

        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    public function applyWidgets($content){
        $pattern = '#\[[^\]]*\]#';
        preg_match_all($pattern, $content, $out);

        foreach ($out[0] as $widget){
            //widget = [members nb=2]
            $tabParams = [];
            $tabParams['widgetName'] = $widget;
            $widget = str_replace(array('[',']'), '', $widget);
            //widget = members nb=2
            $tabWidget = explode(" ", $widget);
            //tabWidget[0] = members
            //tabWidget[1] = limit=2
            //tabWidget[2] = start=1

            $method = 'widget' .ucfirst($tabWidget[0]);
            //$method = widgetMembers
            array_shift($tabWidget);
            //tabWidget[0] = limit=2
            //create params array

            foreach ($tabWidget as $params){
                //0 limit=2
                //1 start=1
                $tmpParams = explode('=', $params);
                //tmpParams[0]= limit
                //tmpParams[1]= 2
                $tabParams[$tmpParams[0]] = $tmpParams[1];
            }

            $content = $this->$method($tabParams, $content);
        }
        return $content;
    }

    public function widgetMembers($tabParams, $content){

        $limit = isset($tabParams['limit']) ? $tabParams['limit'] : 3;

        $members = $this->entityManager->getRepository(Member::class)->findBy([],[], $limit);

        $context = ['members' => $members];

        $widgetMembers = $this->twig->render('widget/members.html.twig', $context);

        $content = str_replace($tabParams['widgetName'], $widgetMembers, $content);

        return $content;
    }

}