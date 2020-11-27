<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            ImageField::new('image', 'Photo')
                ->setUploadDir('public' . $this->params->get('app.path.member_images'))
                ->setTemplatePath('admin/vich_uploader_image.html.twig'),

            TextField::new('firstname'),
            TextField::new('lastname')
        ];
    }

}
