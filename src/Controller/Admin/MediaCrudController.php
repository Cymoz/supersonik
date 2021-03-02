<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MediaCrudController extends AbstractCrudController
{

    /**
     * @var ParameterBagInterface
     */
    private $params;

    public function __construct(ParameterBagInterface $params){

        $this->params = $params;
    }

    public static function getEntityFqcn(): string
    {
        return Media::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('projects', 'Projets'),
            TextField::new('name'),
            TextField::new('alias'),
            TextField::new('imageFile', 'image')
                ->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('image', 'image')
                ->setBasePath($this->params->get('app.path.media_images'))->onlyOnIndex()
                ->setTemplatePath('admin/vich_uploader_image.html.twig')
        ];
    }

}
