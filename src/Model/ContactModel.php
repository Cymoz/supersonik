<?php


namespace App\Model;

//use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;
use Symfony\Component\Validator\Constraints as Assert;

class ContactModel
{

    /**
     * @var string
     * @Assert\NotBlank(message="Le nom est obligatoire")
     */
    public $name;

    /**
     * @var string
     * @Assert\NotBlank(message="L'email est obligatoire")
     * @Assert\Email(message="L'email n'a pas le bon format")
     */
    public $email;

    /**
     * @var string
     * @Assert\NotBlank(message="Le message est obligatoire")
     */
    public $message;

    /**
    *
    */
    public $recaptcha;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ContactModel
     */
    public function setName($name): ContactModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return ContactModel
     */
    public function setEmail($email): ContactModel
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of message
     *
     * @return  string
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return ContactModel
     */
    public function setMessage($message): ContactModel
    {
        $this->message = $message;
        return $this;
    }



    /**
     * Get the value of recaptcha
     */ 
    public function getRecaptcha()
    {
        return $this->recaptcha;
    }

    /**
     * Set the value of recaptcha
     *
     * @return  self
     */ 
    public function setRecaptcha($recaptcha)
    {
        $this->recaptcha = $recaptcha;

        return $this;
    }
}