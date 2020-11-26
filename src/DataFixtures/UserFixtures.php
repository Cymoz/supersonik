<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $encodedPassword = $this->passwordEncoder->encodePassword($user,'admin');

        $user->setPassword($encodedPassword)->setEmail('admin@admin.com');
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $user = new User();
        $encodedPassword = $this->passwordEncoder->encodePassword($user,'admin2');

        $user->setPassword($encodedPassword)->setEmail('admin2@admin.com');
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $manager->flush();
    }
}
