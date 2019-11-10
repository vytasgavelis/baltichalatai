<?php


namespace App\Controller;
use App\Entity\Specialty;
use App\Repository\UserSpecialtyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $choices = Array();
        $specialties = $this->getDoctrine()->getRepository(
            Specialty::class)->findAll();
        foreach($specialties as $specialty) {
            $choices += array($specialty->getName() => $specialty->getId());
        }

        $form = $this->createFormBuilder([])
            ->add('name', TextType::class, ['required' => false])
            ->add('city', TextType::class, ['required' => false])
            ->add('specialties', ChoiceType::class, [
                'choices' => $choices
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
        return new Response(
            '<html><body>' . $city . '</body></html>'
        );
    }

    public function validateInput($input)
    {
        if ($input === '') {
            return 0;
        } else {
            return $input;
        }
    }
}