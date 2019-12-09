<?php

namespace App\Form;

use App\Entity\ClinicInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClinicInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label'=> 'Pavadinimas', 'empty_data' => '',])
            ->add('address', null, ['label'=> 'Adresas', 'empty_data' => '',])
            ->add('webpage', null, ['label'=> 'Svetainė', 'empty_data' => '',])
            ->add('email', null, ['label'=> 'El. Paštas', 'empty_data' => '',])
            ->add('description', TextType::class, ['label'=> 'Aprašymas', 'empty_data' => '',])
            ->add('phoneNumber', null, ['label'=> 'Tel. Nr.', 'empty_data' => '',])
            ->add('save', SubmitType::class, ['label'=> 'Išsaugoti']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClinicInfo::class,
        ]);
    }
}
