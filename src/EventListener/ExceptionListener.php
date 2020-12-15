<?php


namespace App\EventListener;


use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception->getCode() == 404) {
            dd($exception);
        }

    }

}