<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\ContactType;
use App\Model\ContactModel;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefaultController extends AbstractController
{

    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $members = $em->getRepository('App:Member')->findAll();
        /**@var \App\Entity\Member $member */


        $context = [
            'controller_name' => 'DefaultController',
            'members' => $members
        ];

        return $this->render('default/index.html.twig', $context);
    }

    /**
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function contact(Request $request, \Swift_Mailer $mailer, TranslatorInterface $translator, MemberRepository $repository): Response
    {
        $test = $repository->findBy(["email" => true]);
        dump($test);

        $contact = new ContactModel();
        $formOptions = [
            'method' => Request::METHOD_POST,

        ];

        $form = $this->createForm(ContactType::class, $contact, $formOptions);

        if($request->getMethod() == Request::METHOD_POST){
            $form->handleRequest($request);
            /**
             * @var ContactModel $contact
             */
            $contact = $form->getData();

            if($form->isSubmitted() && $form->isValid()){
                dump($contact);
                $receiver = ['mounir.senaoui@gmail.com'];
                $sender = 'mounir.senaoui@gmail.com';
                $replyTo = $contact->getEmail();

                $message = (new \Swift_Message('Contact depuis le site'))
                    ->setTo($receiver)
                    ->setSender($sender)
                    ->setReplyTo($replyTo)
                    ->setBody(
                        $this->render('mail/contact_form.html.twig', [
                            'contact' => $contact
                        ]), 'text/html'
                    );

                $result = $mailer->send($message);
                if($result){
                    $this->addFlash('success', $translator->trans('Votre message a bien été envoyé', [],'form'));
                }else{
                    $this->addFlash('error', $translator->trans('PROBLEME !', [],'form'));
                }

                return $this->redirectToRoute("contact");
            }
        }

        $context = [
            "form" => $form->createView()
        ];
        return $this->render('default/contact.html.twig', $context);
    }

    public function page(Request $request, EntityManagerInterface $em, $slug){
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
        $page = $em->getRepository("App:Page")->getOneBySlug($slug);

        if(!$page){
            throw new NotFoundHttpException("404",null,404);
        }

        $template = $page->getTemplate() ?: 'page/default.html.twig';

        $context['page'] = $page;

        return $this->render($template, $context);
    }
}
