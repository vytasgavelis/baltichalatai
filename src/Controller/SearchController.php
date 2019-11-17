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
        $choices = array();

        $specialties = $this->getDoctrine()->getRepository(Specialty::class)->findAll();

        foreach ($specialties as $specialty) {
            $choices += array($specialty->getName() => $specialty->getId());
        }

        $form = $this->createFormBuilder([])
            ->add('name', TextType::class, ['required' => false])
            ->add('city', TextType::class, ['required' => false])
            ->add('specialties', ChoiceType::class, [
                'choices' => $choices,
                'required' => false,
            ])
            ->add('search', SubmitType::class, ['label' => 'Ieskoti'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('search', $form->getData());
        }

        return $this->render('home/index.html.twig', ['search_form' => $form->createView()]);
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @return Response
     */
    public function results(Request $request)
    {
        $specialists = $this->getDoctrine()->getRepository(User::class)->search(
            $request->get('name'),
            $request->get('city'),
            $request->get('specialties')
        );
        $data = [];
        foreach ($specialists as $specialist) {
            $arr['id'] = $specialist->getId();
            $arr['name'] = $specialist->getUserInfo()->first()->getName();
            $arr['surname'] = $specialist->getUserInfo()->first()->getSurname();
            $arr['city'] = $specialist->getUserInfo()->first()->getCity();
            $arr['specialty'] = $specialist->getUserSpecialties()->first()->getSpecialtyId()->getName();
            $data[] = $arr;
        }

        //echo json_encode($data);
        /*return $this->render('rezultatai.html.twig',[
           'specialists' => $specialists
        ]);*/

        return $this->render('home/results.html.twig', ['specialists' => $data]);
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
