<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\ContactType;
use App\Model\ContactModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $members = $entityManager->getRepository(Member::class)->findAll();
        $context = 
            [
                'controller_name' => 'DefaultController',
                'members' => $members
            ];
        return $this->render('default/index.html.twig', $context);
    }

    public function page(Request $request, $slug, EntityManagerInterface $em)
    {
        $tabLocales = $this->getParameter('locales');

        $tabTmp = explode('/', $slug);
        if (in_array($tabTmp[0], $tabLocales)) {
            unset($tabTmp[0]);
            $slug = implode('/', $tabTmp);
        }

        /** @var $page \App\Entity\Page **/
        $page = $em->getRepository('App:Page')->getOneBySlug($slug);

        if (!$page) {
            throw new NotFoundHttpException('404', null, 404);
        }

        $template = $page->getTemplate() ?: 'page/default.html.twig';
        $context['page'] = $page;
        return $this->render($template, $context);
    }

    public function contact(Request $request, \Swift_Mailer $mailer, TranslatorInterface $translator): Response
    {
        $context = [];
        $contact = new ContactModel();
        $formOptions = [];
        $form = $this->createForm(ContactType::class, $contact, $formOptions);
        if ($request->getMethod() === Request::METHOD_POST) {
            $form->handleRequest($request);
            /** @var ContactModel $contact **/
            $contact = $form->getData();
            if ($form->isSubmitted() && $form->isValid() ) {

                $receiver = array('admin@kilkenny.fr');
                $sender = 'admin@kilkenny.fr';
                $replyTo = $contact->getEmail();

                $message = (new \Swift_Message('Contact from website'))
                    ->setTo($receiver)
                    ->setSender($sender)
                    ->setReplyTo($replyTo)
                    ->setBody(
                        $this->render('mail/contact_form.html.twig',
                            array('contact' => $contact)
                    ),
                        'text/html'
                    );
                $result = $mailer->send($message);

                if ($result) {
                    $this->addFlash('success', $translator->trans('Votre message a bien été envoyé', [], 'form'));
                } else {
                    $this->addFlash('danger', $translator->trans('Votre message n\'a pu être envoyé', [], 'form'));
                }

                /*$contact = new ContactModel();
                $form = $this->createForm(ContactType::class, $contact, $formOptions);*/
                return $this->redirectToRoute('contact');
    
            }
        }
        $context['form'] = $form->createView();
        return $this->render('default/contact.html.twig', $context);
    }
}
