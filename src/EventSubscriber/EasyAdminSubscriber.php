<?php

# src/EventSubscriber/EasyAdminSubscriber.php
namespace App\EventSubscriber;

use App\Entity\Member;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    /**
     * @var CacheManager
     */
    private $manager;
    /**
     * @var UploaderHelper
     */
    private $helper;

    public function __construct(CacheManager $manager, UploaderHelper $helper)
    {
        $this->manager = $manager;
        $this->helper = $helper;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityDeletedEvent::class => ['imageDelete'],
        ];
    }


    public function imageDelete(BeforeEntityDeletedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if($entity instanceof Member){
            $this->manager->remove($this->helper->asset($entity,"imageFile"));
        }

    }
}
