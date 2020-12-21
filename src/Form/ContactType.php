<?php

namespace App\Form;

use App\Entity\Member;
use App\Model\ContactModel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\Translator;
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
     * @param EntityManagerInterface $manager
     */
    public function __construct(TranslatorInterface $translator, EntityManagerInterface $manager){

        $this->translator = $translator;
        $this->manager = $manager;
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
            ->add('message', TextareaType::class, [
                'label' => $this->translator->trans('contact.form.label.message', [], 'form'),
                'attr' => [
                    'placeholder' => $this->translator->trans('contact.form.placeholder.message', [], 'form')
                ]
            ])
//            ->add('destinataire', EntityType::class, [
//                'label' => $this->translator->trans('contact.form.label.destinataire', [], 'form'),
//                    'class' => Member::class,
//                    'query_builder' => function (EntityRepository $er) {
//                        return $er->createQueryBuilder('m')
//                            ->where('m.email IS NOT NULL');
//                    },
//                    'choice_label' => 'job',
//
//                ]
//            )
                ->add('destinataire', ChoiceType::class, [
                    'choices' => $this->getMembersWithEmail()
                ]

            )
            ->add('recaptcha', EWZRecaptchaType::class, [
                'label' => false,
                'language' => '%locales%',
                'attr' => [
                    'options' => [
                        'theme' => 'light',
                        'type' => 'image',
                        'size' => 'normal',
                        'defer' => true,
                        'async' => true,
                    ]
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactModel::class
        ]);
    }

    private function getMembersWithEmail(){
        $members = $this->manager->getRepository(Member::class)->findMembersWithEmail();
        $emails["Agence"] = "agence@agence.fr";
        foreach($members as $key => $member){
            $emails[$member->getJob()] = $member->getEmail();
        }
        return $emails;
    }
}
