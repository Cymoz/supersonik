<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\ContactType;
use App\Model\ContactModel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefaultController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var TranslatorInterface
     */
    private $translator;


    /**
     * DefaultController constructor.
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     */
    public function __construct(EntityManagerInterface $entityManager, TranslatorInterface $translator)
    {

        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    public function index(): Response
    {


        $members = $this->entityManager->getRepository('App:Member')->findAll();

        $context = [
            'controller_name' => 'DefaultController',
            'members' => $members
        ];

        return $this->render('default/index.html.twig', $context);
    }

    public function contact(Request $request, \Swift_Mailer $mailer): Response
    {
        $context = [];

        $contact = new ContactModel();


        $form = $this->createForm(ContactType::class, $contact);

        if ($request->getMethod() === Request::METHOD_POST) {
            $form->handleRequest($request);
            $contact = $form->getData();

            if ($form->isSubmitted() && $form->isValid()) {
                $receiver = $contact->getDestinataire();

                dd($receiver);
                $sender = 'godefroy@admin.fr';
                $replyTo = $contact->getEmail();

                $message = (new \Swift_Message('Contact depuis le moyen-age'))
                    ->setTo($receiver)
                    ->setSender($sender)
                    ->setReplyTo($replyTo)
                    ->setBody(
                        $this->render('mail/contact_email.html.twig',
                            array('contact' => $contact)
                        ),
                        'text/html'
                    );
                $result = $mailer->send($message);

                if ($result) {
                    $this->addFlash('ContactSuccess', $this->translator->trans('contact.form.success',[], 'form'));

                } else
                    $this->addFlash('ContactError', $this->translator->trans('contact.form.error', [], 'form'));

                return $this->redirect($request->getUri());
            }
        }

        $context['form'] = $form->createView();


        return $this->render('default/contact.html.twig', $context);
    }

    public function page($slug): Response
    {

        $tabLocales = $this->getParameter('locales');

        $tabTmp = explode("/", $slug);

        if (in_array($tabTmp[0], $tabLocales)) {
            unset($tabTmp[0]);
            $slug = implode("/", $tabTmp);

        }

        $page = $this->entityManager->getRepository('App:Page')->getOneBySlug($slug);


        if (!$page) {
            throw new NotFoundHttpException('404', null, 404);
        }

        $template = $page->getTemplate() ?: 'page/default.html.twig';

        $context['page'] = $page;

        return $this->render($template, $context);
    }

}
