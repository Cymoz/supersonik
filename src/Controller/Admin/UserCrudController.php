<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCrudController extends AbstractCrudController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;

    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            EmailField::new('email')
                ->setHelp("L'email doit être unique")
                ->setTemplatePath('admin/fields/_switch_user.html.twig'),

            TextField::new('firstname','Prénom'),

            TextField::new('lastname','Nom'),

            TextEditorField::new('description'),

            ChoiceField::new('roles')
                ->allowMultipleChoices()
                ->setChoices(User::ROLES),

            TextField::new('plainPassword', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->onlyOnForms(),

            BooleanField::new('active')->hideOnForm()
        ];
    }

    /**
     *
     * @param EntityManagerInterface $entityManager
     * @param $entityInstance
     */

     public function updateEntity(EntityManagerInterface $entityManager, $entity): void
     {
         if ($entity->getPlainPassword()){
             $password = $this->passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
             $entity->setPassword($password);

         }
         parent::updateEntity($entityManager, $entity);
     }
}
