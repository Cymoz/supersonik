<?php

namespace App\Controller\Admin;

use App\Admin\Field\TranslationField;
use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
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
        return [
            TranslationField::new('translations', "Label")
                ->setRequired(true)
                ->hideOnIndex()
        ];
    }

}
