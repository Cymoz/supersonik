<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $encodePassword = $this->encoder->encodePassword($user, 'admin');

        $user->setPassword($encodePassword)
            ->setFirstName('John')
            ->setLastName('Malkovitch')
            ->setEmail('admin@admin.com')
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $manager->flush();

        $user = new User();
        $encodePassword = $this->encoder->encodePassword($user, 'admin2');

        $user->setPassword($encodePassword)
            ->setFirstName('Thomas')
            ->setLastName('Anderson')
            ->setEmail('admin2@admin.com')
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $manager->flush();
    }
}
