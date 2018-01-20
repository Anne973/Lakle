<?php

namespace AppBundle\DataFixtures;



use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture

{
    private  $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {

            $user1 = new User();
            $user1->setUsername('Anne');
            $password = $this->encoder->encodePassword($user1, 'kikiwi');
            $user1->setPassword($password);
            $user1->setEmail('anne.derenoncourt@gmail.com');



            $manager->persist($user1);


        $manager->flush();
    }
}