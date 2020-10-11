<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{
    private EncoderFactoryInterface $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager)
    {
        $admin = (new Admin())
       ->setRoles(['ROLE_ADMIN'])
       ->setUsername('Admin')
       ->setPassword($this->encoderFactory->getEncoder(Admin::class)->encodePassword('admin', null));
        $manager->persist($admin);

        $amsterdam = (new Conference())
           ->setCity('Amsterdam')
           ->setYear('2019')
           ->setIsInternational(true)
           ->setSlug('amsterdam');
        $manager->persist($amsterdam);

        $paris = (new Conference())
            ->setCity('Paris')
            ->setYear('2020')
            ->setIsInternational(false)
            ->setSlug('paris');
        $manager->persist($paris);

        $comment1 = (new Comment())
            ->setConference($amsterdam)
            ->setAuthor('Anthony')
            ->setEmail('ari@yopmail.com')
            ->setText('Ho Yeah baby !');
        $manager->persist($comment1);

        $manager->flush();
    }
}
