<?php
namespace App\EventListener;

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
            dump("test1");
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
            dump("test2");
            $this->mailer->send($message);
            dump("test3");
        }
    }
}