<?php
namespace App\EventSubscriber;

use App\Entity\Member;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber
{

    /**
     * @var CacheManager
     */
    private $cacheManager;
    /**
     * @var UploaderHelper
     */
    private $helper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $helper)
    {
        $this->cacheManager = $cacheManager;
        $this->helper = $helper;
    }

    public function preUpdate(PreUpdateEventArgs $args){
        $entity = $args->getEntity();

        if (!$entity instanceof Member){
            return;
        }
            if($entity->getImageFile() instanceof UploadedFile){
                $this->cacheManager->remove($this->helper->asset($entity,"imageFile"));
            }
    }

    public function preRemove(LifecycleEventArgs $args){
        $entity = $args->getObject();
        if(!$entity instanceof Member){
           return;
        }
        $this->cacheManager->remove($this->helper->asset($entity,"imageFile"));
    }

    public function getSubscribedEvents()
    {
        return [
            "preRemove",
            "preUpdate"
        ];
    }
}