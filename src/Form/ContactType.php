<?php

namespace App\Form;

use App\Model\ContactModel;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaV3Type;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrueV3;
use Symfony\Component\Translation\Translator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactType extends AbstractType
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * ContactType constructor.
     * @param Translator $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                [
                    'label' => $this->translator->trans('contact.form.label.name', [], 'form'),
                    'attr' => [
                        'placeholder' => $this->translator->trans('contact.form.placeholder.name', [], 'form')
                    ]
                ])
            ->add('email', EmailType::class, [
                'label' => $this->translator->trans('contact.form.label.email', [], 'form'),
                'attr' => [
                    'placeholder' => $this->translator->trans('contact.form.placeholder.email', [], 'form')
                ]
            ])
            ->add('message', TextareaType::class,
                [
                    'label' => $this->translator->trans('contact.form.label.message', [], 'form'),
                    'attr' => [
                        'placeholder' => $this->translator->trans('contact.form.placeholder.message', [], 'form')
                    ]
                ])
            ->add('recaptcha', EWZRecaptchaV3Type::class, 
            [
                    'action_name' => 'contact',
                    // 'constraints' => [
                    //     new IsTrueV3()
                    // ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactModel::class
        ]);
    }
}
