<?php
namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ContactModel{

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Le nom est obligatoire"
     * )
     */
    private $name;

    /**
     * @var string
     * @Assert\Email(
     *     message="L'email doit être au formal email"
     * )
     * @Assert\NotBlank(
     *     message="L'email est obligatoire"
     * )
     */
    private $email;


    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Le message est obligatoire"
     * )
     */
    private $message;


    private $recaptcha;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ContactModel
     */
    public function setName(string $name): ContactModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return ContactModel
     */
    public function setEmail(string $email): ContactModel
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return ContactModel
     */
    public function setMessage(string $message): ContactModel
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRecaptcha()
    {
        return $this->recaptcha;
    }

    /**
     * @param mixed $recaptcha
     */
    public function setRecaptcha($recaptcha): void
    {
        $this->recaptcha = $recaptcha;
    }


}