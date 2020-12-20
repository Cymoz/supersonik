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
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MemberCrudController extends AbstractCrudController
{
    private $params;

    /**
     * MemberCrudController constructor.
     * @param $params
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
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
                    '@EasyAdmin/crud/form_theme.html.twig',
                    '@A2lixTranslationForm/bootstrap_4_layout.html.twig',
                    '@FOSCKEditor/Form/ckeditor_widget.html.twig'
                ]
            );
    }

    public function configureFields(string $pageName): iterable
    {
        $fieldsConfig = [
            'description' => [
                'field_type' => CKEditorType::class,
                'required' => true,
                'label' => 'Description'
            ]
        ];

        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('firstName'),
            TextField::new('lastName'),
            TextField::new('email'),
            TextField::new('job'),

            ImageField::new('imageName', 'Image')
                ->setUploadDir('public' . $this->params->get('app.path.member_images'))
                ->setTemplatePath('admin/vich_uploader_image.html.twig')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]'),

            TranslationField::new('translations', 'Details', $fieldsConfig)
                ->setRequired(true)
                ->hideOnIndex()
        ];
    }

}
