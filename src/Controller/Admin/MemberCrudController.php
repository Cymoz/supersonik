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

        $imageName = ImageField::new('imageName', 'Photo')
            ->setBasePath($this->params->get('app.path.member_images'))->onlyOnIndex()
            ->setTemplatePath('admin/vich_uploader_image.html.twig')
//            ->setUploadedFileNamePattern('[timestamp]-[slug].[extension]')
        ;
        $imageFile = TextField::new('imageFile', 'Photo')
            ->setFormType(VichImageType::class)->onlyOnForms()
//            ->setUploadedFileNamePattern('[timestamp]-[slug].[extension]')
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

            $imageFile,
            $imageName,

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
