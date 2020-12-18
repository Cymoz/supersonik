<?php

namespace App\Controller\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Admin\Field\TranslationField;
use App\Entity\Member;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MemberCrudController extends AbstractCrudController
{
    private $params;

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
                'label' => 'description'
            ]
        ];

        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            ImageField::new('imageName', 'Photo')
                ->setUploadDir('public'.$this->params->get('app.path.member_images'))
                ->setBasePath('public' . $this->params->get('app.path.member_images'))
                ->setTemplatePath('admin/vich_uploader_image.html.twig')
                ->setUploadedFileNamePattern('[timestamp]-[slug].[extension]'),
            TranslationField::new('translations', 'Détails', $fieldsConfig)
                ->setRequired(true)
                ->hideOnIndex()
        ];
    }
}
