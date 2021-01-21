<?php
namespace App\EventSubscriber;

use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Twig\Environment;

class RequestSubscriber implements EventSubscriberInterface
{
    use TargetPathTrait;

    private $session;
    private $twig;


    public function __construct(Environment $twig,SessionInterface $session)
    {
        $this->session = $session;
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (
            !$event->isMasterRequest()
            || $request->isXmlHttpRequest()
            || 'app_login' === $request->attributes->get('_route')
        ) {
            return;
        }



        $this->twig->addGlobal('test','oki');

        $this->saveTargetPath($this->session, 'main', $request->getUri());
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest']
        ];
    }
}
