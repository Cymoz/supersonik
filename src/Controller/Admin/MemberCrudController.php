<?php

namespace App\Controller\Admin;

use App\Admin\Field\TranslationField;
use App\Entity\Member;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setFormThemes(
                [
                    '@A2lixTranslationForm/bootstrap_4_layout.html.twig',
                    '@EasyAdmin/crud/form_theme.html.twig',
                    '@FOSCKEditor/Form/ckeditor_widget.html.twig'
                ]
            );
    }


    public function configureFields(string $pageName): iterable
    {

        $imageFile = ImageField::new('imageFile', 'Photo')
            ->setUploadDir('public' . $this->params->get('app.path.member_images'))
            ->setTemplatePath('admin/vich_uploader_image.html.twig')
            ->setUploadedFileNamePattern('[timestamp]-[slug].[extension]')
        ;
        $imageName = ImageField::new('imageName', 'Photo')
            ->setUploadDir('public' . $this->params->get('app.path.member_images'))
            ->setTemplatePath('admin/vich_uploader_image.html.twig')
            ->setUploadedFileNamePattern('[timestamp]-[slug].[extension]')
            ;

        $fieldsConfig = [
            "description" => [
                'field_type' => CKEditorType::class,
                'required' => true,
                'label' => 'Description'
            ]
        ];

        $fields =  [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('email'),

            ImageField::new('imageName', 'Photo')
                ->setUploadDir('public' . $this->params->get('app.path.member_images'))
                //->setFormType(VichImageType::class)
                ->setBasePath('public' . $this->params->get('app.path.member_images'))
                ->setTemplatePath('admin/vich_uploader_image.html.twig')
                ->setUploadedFileNamePattern('[timestamp]-[slug].[extension]'),

            TranslationField::new('translations', "Label", $fieldsConfig)
                ->setRequired(true)
                ->hideOnIndex()

        ];

       /* if($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL){
            $fields[] = $imageName;
        }else{
            $fields[] = $imageFile;
        }*/

        return $fields;


    }





}
