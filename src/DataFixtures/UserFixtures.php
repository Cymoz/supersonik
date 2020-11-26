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
                        'admin'))
                ->setEmail('admin@admin.com')
                ->setFirstname('admin')
                ->setLastname('admin')
                ->setActive(1);
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword(
                         $user,
                        'admin'))
                ->setEmail('jacky@tuning.com')
                ->setFirstname('jacky')
                ->setLastname('tuning')
                ->setActive(1);

        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $manager->flush();
    }
}
