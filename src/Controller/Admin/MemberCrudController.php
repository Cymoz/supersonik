<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\CrudDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class MemberCrudController extends AbstractCrudController
{
    private $params;
    private $cacheManager;
    private $uploaderHelper;


    public function __construct(ParameterBagInterface $params, CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->params = $params;
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public static function getEntityFqcn(): string
    {
        return Member::class;
    }


    public function configureFields(string $pageName): iterable
    {

        $imageFile = ImageField::new('imageFile', 'Photo')->setFormType(VichImageType::class);
        $imageName = ImageField::new('imageName', 'Photo')->setBasePath('public' . $this->params->get('app.path.member_images'));

        $fields =  [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('firstname'),
            TextField::new('lastname'),

            ImageField::new('imageName', 'Photo')
                ->setUploadDir('public' . $this->params->get('app.path.member_images'))
                //->setFormType(VichImageType::class)
                ->setBasePath('public' . $this->params->get('app.path.member_images'))
                ->setTemplatePath('admin/vich_uploader_image.html.twig'),

        ];

       /* if($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL){
            $fields[] = $imageName;
        }else{
            $fields[] = $imageFile;
        }*/

        return $fields;


    }

    /**
     *
     * @param EntityManagerInterface $entityManager
     * @param $entityInstance
     */
    public function persistEntity(EntityManagerInterface $entityManager, $member): void
    {

     /*   //dd($member);

        /**@var \App\Entity\Member $member */
        /*
        if($member->getImageFile() instanceof UploadedFile){
            dd('image');
            //$this->cacheManager->remove($this->uploaderHelper->asset($member,'imageFile'));
        }*/

        parent::updateEntity($entityManager, $member);
    }

}
