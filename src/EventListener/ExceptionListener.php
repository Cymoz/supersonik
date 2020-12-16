<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event){
        dd($event);
    }
}