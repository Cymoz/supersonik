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
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
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
            TextField::new('firstName'),
            TextField::new('lastName'),
            TextField::new('plainPassword', 'Password')
                ->setFormType(PasswordType::class)
                ->onlyOnForms(),
            TextEditorField::new('description'),
            ChoiceField::new('roles')
                ->allowMultipleChoices()
                ->setChoices(User::ROLES),
            BooleanField::new('active')->hideOnForm()
        ];
    }


    /**
     * @param EntityManagerInterface $entityManager
     * @param $user
     */
    public function updateEntity(EntityManagerInterface $entityManager, $user): void
    {
        if ($user->getPlainPassword()){
            $password = $this->encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
        }

        parent::updateEntity($entityManager, $user);
    }

}
