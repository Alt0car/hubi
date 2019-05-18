<?php

namespace App\DataFixtures;

use App\Entity\Score;
use App\Entity\Student;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use \DateTime;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // set language used
        $faker = Faker\Factory::create('fr_FR');
        $date = new DateTime();
        $class = [
            'Français',
            'Mathématiques',
            'Anglais',
            'Histoire et Géographie',
            'Éducation Civique (HG - EC)',
            'Sciences de la Vie et de la Terre (SVT)',
            'Technologie',
        ];

        // create 10 fake users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail(sprintf('usertest%d@example.com', $i));
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    'usertest'
                )
            );
            $manager->persist($user);
        }


        // create 250 fake students
        for ($i = 0; $i < 250; $i++) {
            $student = new Student();
            $student->setLastName($faker->lastName);
            $student->setFirstName($faker->firstName());
            $student->setBirthDate($date);
            $manager->persist($student);

            // generate 50 score per student
            for ($x = 0; $x < 50; $x++) {
                $score = new Score();
                $score->setScore(rand(0, 20));
                $rand_keys = array_rand($class, 1);
                $score->setClass($class[$rand_keys]);
                $score->setStudent($student);
                $manager->persist($score);
            }
        }

        $manager->flush();

    }

}