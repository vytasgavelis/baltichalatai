<?php

namespace App\Form;

use App\Entity\UserInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label'=> 'Vardas'])
            ->add('surname', null, ['label'=> 'Pavardė'])
            ->add('phoneNumber', null, ['label'=> 'Telefono Nr.'])
            ->add('personalEmail', null, ['label'=> 'El. Paštas'])
            ->add('dateOfBirth', DateType::class, [
                'years' => range(date('Y') - 100, date('Y')), 'label'=> 'Gimimo Data'])
            ->add('city', TextType::class, ['label'=> 'Miestas'])
            ->add('personCode', null, ['label'=> 'Asmens Kodas'])
            ->add('description', TextType::class, ['label'=> 'Aprašymas'])
            ->add('save', SubmitType::class,['label'=> 'Išsaugoti']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserInfo::class,
        ]);
    }
}
