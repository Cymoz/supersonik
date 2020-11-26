<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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
                ->setTemplatePath('admin/fields/switch_user.html.twig'),

            TextField::new('firstname', 'Prénom'),


            TextField::new('lastname', 'Nom'),

            TextEditorField::new('description', 'Description'),

            ChoiceField::new('roles', 'Roles')
                ->allowMultipleChoices()
                ->setChoices(User::ROLES),

            TextField::new('plainPassword', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->onlyOnForms(),

            BooleanField::new('active')->hideOnForm()
        ];
    }



    public function configureActions(Actions $actions): Actions
    {

        return $actions
            // ...
            // this will forbid to create or delete entities in the backend
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                $user = $this->getUser();
                return $action->displayIf(function(User $entity){
                    return $this->getUser()->getUsername() !== $entity->getUsername();
                });
            })
            ;
    }

    /**
     *
     * @param EntityManagerInterface $entityManager
     * @param $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $user): void
    {
        if ($user->getPlainPassword()) {
            $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());

            /**@var \App\Entity\User $user */
            $user->setPassword($password);
        }

        parent::updateEntity($entityManager, $user);
    }

}
