<?php

namespace App\Controller\Admin;

use App\Admin\Field\TranslationField;
use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
                    '@EasyAdmin/crud/form_theme.html.twig'
                ]
            );
    }


    public function configureFields(string $pageName): iterable
    {
        $fieldsConfig = [
            "title" => [
                "field_type" => TextType::class,
                "required" => true,
                "label" => "Titre"
            ],
            "description" => [
                "field_type" => TextareaType::class,
                "required" => false,
                "label" => "Description"
            ],
            "keywords" => [
                "field_type" => TextType::class,
                "required" => false,
                "label" => "Keywords"
            ],
            "slug" => [
                "field_type" => TextType::class,
                "required" => false,
                "label" => "Slug"
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
