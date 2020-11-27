<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
<<<<<<< HEAD
    private $firstname;
=======
    private $firstName;
>>>>>>> 446e837a159d156f34b837c03fe571a31b856b39

    /**
     * @ORM\Column(type="string", length=50)
     */
<<<<<<< HEAD
    private $lastname;
=======
    private $lastName;
>>>>>>> 446e837a159d156f34b837c03fe571a31b856b39

    public function getId(): ?int
    {
        return $this->id;
    }

<<<<<<< HEAD
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
=======
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
>>>>>>> 446e837a159d156f34b837c03fe571a31b856b39

        return $this;
    }

<<<<<<< HEAD
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
=======
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
>>>>>>> 446e837a159d156f34b837c03fe571a31b856b39

        return $this;
    }
}
