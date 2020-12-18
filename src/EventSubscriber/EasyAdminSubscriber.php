<?php

# src/EventSubscriber/EasyAdminSubscriber.php
namespace App\EventSubscriber;

use App\Entity\Member;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
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
    /**
     * @var EntityRepository
     */
    private $em;

    public function __construct(EntityManagerInterface $em, CacheManager $manager, UploaderHelper $helper)
    {
        $this->manager = $manager;
        $this->helper = $helper;
        $this->em = $em;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityDeletedEvent::class => ['imageDelete'],
            BeforeEntityUpdatedEvent::class => ['imageUpdate'],
        ];
    }

    public function imageUpdate(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        $uow = $this->em->getUnitOfWork();
        $uow->computeChangeSets();
        $changeset = $uow->getEntityChangeSet($entity);

        if (isset($changeset['imageName'])) {
            $this->clearLiipCache($entity, $changeset['imageName'][0]);
        }


        if ($entity instanceof Member) {
            $this->manager->remove($this->helper->asset($entity, "imageFile"));
        }
    }

    public function imageDelete(BeforeEntityDeletedEvent $event)
    {

        $entity = $event->getEntityInstance();

        $this->clearLiipCache($entity);

    }

    private function clearLiipCache($entity, $imageName = null)
    {

        $imagePath = $this->helper->asset($entity, "imageFile");
        if ($imageName) {
            $imagePath = str_replace($entity->getImageName(), $imageName, $imagePath);
        }

        if ($entity instanceof Member) {
            $this->manager->remove($imagePath);
        }
    }
}
