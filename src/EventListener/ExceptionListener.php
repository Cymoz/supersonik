<?php


namespace App\EventListener;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Twig\Environment;

class ExceptionListener
{
    private $twig;
    private $mailer;
    public function __construct(Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception->getCode() == 404) {
            $receiver = array('admin@kilkenny.fr');
            $info = 'Page non trouvé: ' . $event->getRequest()->getPathInfo();

            $message = (new \Swift_Message('404 from website'))
                ->setTo($receiver)
                ->setSender('leo@kilkenny.fr')
                ->setReplyTo('admin@kilkenny.fr')
                ->setBody(
                    $this->twig->render('mail/admin_404.html.twig',
                        array('info' => $info)
                    ),
                    'text/html'
                );
            $this->mailer->send($message);

            $response = new Response($this->twig->render('exception/404.html.twig'), $exception->getCode());

            $event->setResponse($response);
        }
    }
}