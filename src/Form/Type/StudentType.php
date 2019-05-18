<?php

namespace App\Form\Type;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ["label" => "Prénom"])
            ->add('lastName',TextType::class, ["label" => "Nom"])
            ->add('birthDate', DateType::class,['format' => 'yyyy-MM-dd', 'widget' => 'single_text', "label" => "Date de naissance"])
            ->add('Enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'         => Student::class,
                'csrf_protection'    => false,
                "allow_extra_fields" => true,
            )
        );
    }
}