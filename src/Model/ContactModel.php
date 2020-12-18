<?php

namespace App\Model;

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
     * @Assert\Email(message="L'email n'est pas une adresse valide")
     * @Assert\Range()
    */
    public $email;

    /** 
     * @var string
     * @Assert\NotBlank(message="Le message est obligatoire")
    */
    public $message;

    


    /**
     * Get the value of name
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */ 
    public function setName(string $name)
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
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */ 
    public function setEmail(string $email)
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
     * Set the value of message
     *
     * @param  string  $message
     *
     * @return  self
     */ 
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }
}