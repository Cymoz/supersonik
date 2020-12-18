<?php

namespace App\Form;

use App\Model\ContactModel;
use Doctrine\ORM\EntityManagerInterface;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaV3Type;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrueV3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * ContactType constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator, EntityManagerInterface $manager){

        $this->translator = $translator;
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => $this->translator->trans('contact.form.label.name', [], 'form'),
                'attr' => [
                    'placeholder' => $this->translator->trans('contact.form.label.name', [], 'form')
                ]
            ])
            ->add('email', ChoiceType::class,[
                "choices" => $this->getMembersWithEmail()
            ])
            ->add('message', TextareaType::class, [
                'label' => $this->translator->trans('contact.form.label.message', [], 'form'),
                'attr' => [
                    'placeholder' => $this->translator->trans('contact.form.label.message', [], 'form')
                ]
            ])
            ->add('recaptcha', EWZRecaptchaV3Type::class, [
                'action_name' => 'contact',
                /*'constraints' => [
                    new IsTrueV3()
                ]*/
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactModel::class,
        ]);
    }

    private function getMembersWithEmail(){
        $members = $this->manager->getRepository("App:Member")->findMembersWithEmail();
        $emails = [];
        foreach($members as $key => $member){
            $emails[$member->getfirstName()] = $member->getEmail();
        }
        $emails["Agence"] = "agence@agence.fr";
        return $emails;
    }
}
