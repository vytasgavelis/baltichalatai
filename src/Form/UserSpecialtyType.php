<?php


namespace App\Form;


use App\Entity\Specialty;
use App\Entity\UserInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSpecialtyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

//        $choices = array();
//
//        $specialties = $this->getDoctrine()->getRepository(Specialty::class)->findAll();
//
//        foreach ($specialties as $specialty) {
//            $choices += array($specialty->getName() => $specialty->getId());
//        }
//
//        $builder
//            ->add('specialties', ChoiceType::class, [
//                'choices' => $choices,
//                'required' => false,
//            ])
//        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserInfo::class,
        ]);
    }
}