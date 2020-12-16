<?php

namespace App\EventListener;

use Twig\Environment;

class ExceptionListener 
{
    private $twig;
    private $mailer;

    public function __construc(Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception->getCode() == 404)
    }
}