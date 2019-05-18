<?php

namespace App\Form\Type;

use App\Entity\Score;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScoreType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'student',
                EntityType::class,
                [
                    // looks for choices from this entity
                    'class' => Student::class,

                    'choice_label' => function (Student $student) {
                        return sprintf('%s %s', $student->getFirstName(), $student->getLastName());
                    },
                    'label'        => 'Etudiant',
                ]
            )
            ->add('class', TextType::class, ["label" => "Matière"])
            ->add('score', TextType::class, ["label" => "Note"])
            ->add('Enregistrer', SubmitType::class);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'         => Score::class,
                'csrf_protection'    => false,
                "allow_extra_fields" => true,
            )
        );
    }
}