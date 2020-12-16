<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Twig\Environment;

class ExceptionListener
{

    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(Environment $twig, \Swift_Mailer $mailer){

        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function onKernelException( ExceptionEvent $event){
        $exception = $event->getThrowable();

        if($exception->getCode() == 404){

            $receiver = ['mounir.senaoui@gmail.com'];
            $info = 'Test de contenu';

            $message = (new \Swift_Message('404 depuis le site'))
                ->setTo($receiver)
                ->setSender('mounir.senaoui@gmail.com')
                ->setReplyTo('admin@admin.fr')
                ->setBody(
                    $this->twig->render('mail/admin_404.html.twig', [
                        'info' => $info
                    ]), 'text/html'
                );

            $this->mailer->send($message);

            $reponse = new Response($this->twig->render('exception/404.html.twig'), $exception->getCode());

            $event->setResponse($reponse);
        }
    }
}