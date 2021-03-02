<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CustomerCrudController extends AbstractCrudController
{

    /**
     * @var ParameterBagInterface
     */
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('project', 'Projets'),
            TextField::new('name'),
            TextField::new('imageFile', 'Logo')
                ->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('logo', 'Logo')
                ->setBasePath($this->params->get('app.path.customer_images'))->onlyOnIndex()
                ->setTemplatePath('admin/vich_uploader_image.html.twig')
//                ->setUploadedFileNamePattern('[timestamp]-[slug].[extension]'),
        ];
    }

}
