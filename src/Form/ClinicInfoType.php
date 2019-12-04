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
            ->add('name', null, ['label'=> 'Vardas'])
            ->add('address', null, ['label'=> 'Adresas'])
            ->add('webpage', null, ['label'=> 'Svetainė'])
            ->add('email', null, ['label'=> 'El. Paštas'])
            ->add('description', TextType::class, ['label'=> 'Aprašymas'])
            ->add('phoneNumber', null, ['label'=> 'Tel. Nr.'])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClinicInfo::class,
        ]);
    }
}
