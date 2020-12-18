<?php

namespace App\Controller;

use App\Entity\Page;
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

        $members = $entityManager->getRepository('App:Member')->findAll();

        $context = [
            'controller_name' => 'DefaultController',
            'members' => $members
        ];

        return $this->render('default/index.html.twig', $context);
    }

    public function contact(Request $request, \Swift_Mailer $mailer, TranslatorInterface $translator): Response
    {
        $context = [];
        
        $contact = new ContactModel();
        $formOptions = [
            // 'method' => Request::METHOD_POST
        ];

        $form = $this->createForm(ContactType::class, $contact, $formOptions);

        if($request->getMethod() === Request::METHOD_POST)
        {
            $form->handleRequest($request);

            /**@var ContactModel $contact */
            $contact = $form->getData();

            if( $form->isSubmitted() && $form->isValid())
            {
                $receiver = ['tarik.graoui@gmail.com'];
                $sender = array('tarik.graoui@gmail.com');
                $replyTo = $contact->getEmail();

                $message = (new \Swift_Message('404 depuis le site'))
                    ->setTo($receiver)
                    ->setSender($sender)
                    ->setReplyTo($replyTo)
                    ->setBody(
                        $this-->render('mail/contact_form.html.twig', [
                            'contact' => $contact
                        ]), 
                        'text/html'
                    );

                $result = $mailer->send($message);

                if ($result){
                    $this->addFlash('ContactSuccess', $translator->trans('Votre message a bien été envoyé'));
                    $this->addFlash('ContactSuccess', $translator->trans('Nous y répondrons dès que possible'));
                }else {
                    $this->addFlash('ContactErro', $translator->trans('Votre n\'a pas pu être envoyé'));
                }

                return $this->redirectToRoute('contact');
            }
        }

        $context['form'] = $form->createView();

        return $this->render('default/contact.html.twig', $context);
    }

    public function page(Request $request, EntityManagerInterface $entityManager, $slug)
    {
        $tabLocales = $this->getParameter("locales");

        $tabTmp = explode("/", $slug);

        if(in_array($tabTmp[0], $tabLocales)){
            /*unset($tabTmp[0]);
            $slug = implode("/", $tabTmp);*/
            $slug = substr($slug, 3, strlen($slug));
        }

        /**
         * @var $page Page
         */
        $page = $entityManager->getRepository('App:Page')->getOneBySlug('test');

        if(!$page){
            throw new NotFoundHttpException("404",null,404);
        }

        $template = $page->getTemplate() ?: 'page/default.html.twig';

        $context['page'] = $page;

        return $this->render($template, $context);
    }
}
