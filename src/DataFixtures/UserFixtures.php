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
         $user->setPassword($this->passwordEncoder->encodePassword(
                 $user,
                 'admin'
             ))
                //->setUsername('admin')
                ->setEmail('admin@admin.com')
                ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'admin2'
            ))
                //->setUsername('admin')
                ->setEmail('admin2@admin.com')
                ->setRoles(['ROLE_ADMIN']);

         $manager->persist($user);
         $manager->flush();
    }
}
