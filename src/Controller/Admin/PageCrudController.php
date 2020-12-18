<?php

namespace App\Controller\Admin;

use App\Admin\Field\TranslationField;
use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
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
        $fieldsConfig = [
            "description" => [
                "field_type" => TextareaType::class,
                "required" => false,
                "label" => "Description"
            ],
            "content" => [
                "field_type" => CKEditorType::class,
                "required" => false,
                "label" => "Contenu",
            ]
        ];


        $fields = [
            TextField::new("alias","Alias")
                ->setRequired(true),
            TextField::new("template","Template"),

            TranslationField::new("translations", "Label", $fieldsConfig)
                ->setRequired(true)
                ->hideOnIndex()

        ];
        return $fields;
    }

}
