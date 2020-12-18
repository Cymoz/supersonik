<?php

namespace App\Form;

use App\Model\ContactModel;
use Doctrine\ORM\EntityManagerInterface;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaV3Type;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrueV3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactType extends AbstractType
{
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
            array(
                'label' => $this->translator->trans('contact.form.label.name', [], 'form'),
                'attr' => array(
                    'placeholder' => $this->translator->trans('contact.form.placeholder.name', [], 'form')
                )
            ))
            ->add('email', EmailType::class,
            array(
                'label' => $this->translator->trans('contact.form.label.email', [], 'form'),
                'attr' => array(
                    'placeholder' => $this->translator->trans('contact.form.placeholder.email', [], 'form')
                )
            ))
            ->add('recipient', ChoiceType::class,
                array(
                    'choices' => $this->getMembersWhoHaveEmail()
                )
            )
            ->add('message',TextareaType::class,
                array(
                    'label' => $this->translator->trans('contact.form.label.message', [], 'form'),
                    'attr' => array(
                        'placeholder' => $this->translator->trans('contact.form.placeholder.message', [], 'form')
                )
            ))
            ->add('recaptcha', EWZRecaptchaV3Type::class,
                array(
                    'action_name' => 'contact',
                    'constraints' => [
                        new IsTrueV3()
                    ],
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactModel::class,
            'method' => Request::METHOD_POST
        ]);
    }


    public function getMembersWhoHaveEmail(EntityManagerInterface $em) {
        /*$entityManager = $this->getDoctrine()->getManager();*/
        $members = $this->$em->getRepository('App:Member')->getMemberWhoHaveEmail();
        $emails = [];
        foreach ($members as $key => $member) {
            $emails[$member->getFirstname()] = $member->getEmail();
        return $emails;
        }
    }
}
