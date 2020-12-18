<?php

namespace App\Form;

use App\Model\ContactModel;
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

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => $this->translator->trans('contact.form.label.name', [], 'form'),
                'attr' => array(
                    'placeholder' => $this->translator->trans('contact.form.placeholder.name', [], 'form')
                )
            ))
            ->add('email', EmailType::class, array(
                'label' => $this->translator->trans('contact.form.label.email', [], 'form'),
                'attr' => array(
                    'placeholder' => $this->translator->trans('contact.form.placeholder.email', [], 'form')
                )
            ))
            ->add('message', TextareaType::class, array(
                'label' => $this->translator->trans('contact.form.placeholder.message', [], 'form'),
                'attr' => array(
                    'placeholder' => $this->translator->trans('contact.form.placeholder.message', [], 'form')
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactModel::class,
            'method' => Request::METHOD_POST
        ]);
    }
}
