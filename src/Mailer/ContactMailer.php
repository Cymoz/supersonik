<?php
namespace App\Mailer;

use App\Model\ContactModel;
use Twig\Environment;

class ContactMailer{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer,Environment $twig){

        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendMail(ContactModel $contact){
        $receiver = ['mounir.senaoui@gmail.com'];
        $sender = 'mounir.senaoui@gmail.com';
        $replyTo = $contact->getEmail();

        $message = (new \Swift_Message('Contact depuis le site'))
            ->setTo($receiver)
            ->setSender($sender)
            ->setReplyTo($replyTo)
            ->setBody(
                $this->twig->render('mail/contact_form.html.twig', [
                    'contact' => $contact
                ]), 'text/html'
            );

        return $this->mailer->send($message);
    }
}