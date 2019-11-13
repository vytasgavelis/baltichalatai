<?php


namespace App\Controller;
use App\Entity\Specialty;
use App\Entity\User;
use App\Entity\UserSpecialty;
use App\Entity\UserInfo;
use App\Repository\UserSpecialtyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        // First select value
        $choices = Array();
        $choices += array('-' => '');

        $specialties = $this->getDoctrine()->getRepository(
            Specialty::class)->findAll();

        foreach($specialties as $specialty) {
            $choices += array($specialty->getName() => $specialty->getId());
        }

        $form = $this->createFormBuilder([])
            ->add('name', TextType::class, ['required' => false])
            ->add('city', TextType::class, ['required' => false])
            ->add('specialties', ChoiceType::class, [
                'choices' => $choices,
                'required' => false,
            ])
            ->add('search', SubmitType::class, ['label' => 'Search'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $this->validateInput($form->getData()['name']);
            $city = $this->validateInput($form->getData()['city']);
            $specialty = $this->validateInput($form->getData()['specialties']);

            $url = '/search/' . $name . '/' . $city . '/' . $specialty;
            return new RedirectResponse($url);
        }

        return $this->render('home/index.html.twig',['search_form' => $form->createView()]);
    }

    /**
     * @Route("/search/{name}/{city}/{specialty}", name="search")
     */
    public function results($name, $city, $specialty)
    {
        $specialists = Array();
        // Search by name
        if ($name != '0' && $city == '0' && $specialty == '0') {
            $specialists = $this->getDoctrine()->getRepository(UserInfo::class)
                ->findByUserName($name);
        }
        // Search by city
        else if ($name == '0' && $city != '0' && $specialty == '0') {
            $specialists = $this->getDoctrine()->getRepository(UserInfo::class)
                ->findByCity($city);
        }
        // Search by name and city
        else if ($name != '0' && $city != '0' && $specialty == '0') {
            $specialists = $this->getDoctrine()->getRepository(UserInfo::class)
                ->findByUserNameAndCity($name, $city);
        }
        // Search by city and specialty
        else if ($name == '0' && $city != '0' && $specialty != '0') {
            $specialists = $this->getDoctrine()->getRepository(
                UserSpecialty::class)->findBySpecialtyAndCity($specialty, $city);
        }
        // Search by name and specialty
        else if ($name != '0' && $city == '0' && $specialty != '0'){
            $specialists = $this->getDoctrine()->getRepository(
                UserSpecialty::class)->findBySpecialtyAndName($specialty, $name);
        }
        // Search by specialty
        else if ($name == '0' && $city == '0' && $specialty != '0'){
            $specialists = $this->getDoctrine()->getRepository(
                UserSpecialty::class)->findBySpecialty($specialty);
        }

        foreach($specialists as $specialist){
            echo $specialist->getUserId()->getUserInfo()->getName();
        }

        return new Response(
            '<html><body></body></html>'
        );
    }

    public function validateInput($input)
    {
        if ($input == '') {
            return 0;
        } else {
            return $input;
        }
    }


}