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
            ->add('name', null, ['label'=> 'Vardas', 'empty_data' => '',])
            ->add('surname', null, ['label'=> 'Pavardė', 'empty_data' => '',])
            ->add('phoneNumber', null, ['label'=> 'Telefono Nr.', 'empty_data' => '',])
            ->add('personalEmail', null, ['label'=> 'El. Paštas', 'empty_data' => '',])
            ->add('dateOfBirth', DateType::class, [
                'years' => range(date('Y') - 100, date('Y')), 'label'=> 'Gimimo Data'])
            ->add('city', TextType::class, ['label'=> 'Miestas', 'empty_data' => '',])
//            ->add('personCode', null, ['label'=> 'Asmens Kodas'])
            ->add('description', TextType::class, ['label'=> 'Aprašymas', 'required' => false,])
            ->add('save', SubmitType::class, ['label'=> 'Išsaugoti']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserInfo::class,
        ]);
    }
}
