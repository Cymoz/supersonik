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
     * @return string
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
     * @return string
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


}