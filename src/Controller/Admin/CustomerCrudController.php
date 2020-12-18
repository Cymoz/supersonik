<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

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
            ImageField::new('logo', 'Logo')
                ->setUploadDir('public' . $this->params->get('app.path.customer_images'))
                //->setFormType(VichImageType::class)
                ->setBasePath('public' . $this->params->get('app.path.customer_images'))
                ->setTemplatePath('admin/vich_uploader_image.html.twig')
                ->setUploadedFileNamePattern('[timestamp]-[slug].[extension]'),
        ];
    }

}
