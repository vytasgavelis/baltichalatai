<?php
namespace App\Controller;
use App\Entity\SpecialistWorkHours;
use App\Entity\Specialty;
use App\Entity\User;
use App\Entity\UserInfo;
use App\Entity\UserSpecialty;
use App\Form\UserInfoType;
use App\Form\UserSpecialtyType;
use App\Services\SpecialistService;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SpecialistController extends AbstractController
{
    private $specialistService;
    public function __construct(SpecialistService $specialistService)
    {
        $this->specialistService = $specialistService;
    }
    /**
     * @Route("/specialist", name="specialist")
     */
    public function index()
    {
        return $this->render('specialist/index.html.twig', [
            'controller_name' => 'SpecialistController',
        ]);
    }
    /**
     * @Route("/specialist/show/{id}", name="specialist_show")
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $specialist = $this->getDoctrine()->getRepository(User::class)
            ->findByIdAndRole($id, 2);
        if (sizeof($specialist) == 0) {
            throw $this->createNotFoundException();
        } else {
            $workHours = $this->getDoctrine()->getRepository(SpecialistWorkHours::class)
                ->getWorkHours($specialist[0]);
        }
        return $this->render('specialist/index.html.twig', [
            'specialist' => $specialist[0],
            'workHours' => $this->specialistService->getSpecialistHoursFormatted($workHours),
        ]);
    }

    /**
     * @Route("/specialist/edit", name="specialist_edit")
     * @return Response
     */
    public function edit(Request $request, UrlGeneratorInterface $urlGenerator, UserInterface $user = null)
    {

        if ($user instanceof User && $user->getRole() == 2) {
            $choices = array();

            $specialties = $this->getDoctrine()->getRepository(Specialty::class)->findAll();

            foreach ($specialties as $specialty) {
                if(!in_array($specialty, $user->getUserSpecialties()->toArray())) {
                    $choices += array($specialty->getName() => $specialty->getId());
                }
            }

            $specialtiesForm = $this->createFormBuilder([])
                ->add('specialties', ChoiceType::class, [
                    'choices' => $choices,
                    'required' => false,
                ])
                ->add('custom_specialty', TextType::class, ['required' => false])
                ->add('submit', SubmitType::class, ['label' => 'Prideti'])
                ->getForm()
            ;

            // Handle the request
            $specialtiesForm->handleRequest($request);

            if ($specialtiesForm->isSubmitted() && $specialtiesForm->isValid()) {
                if($request->request->get('form')['specialties'] != "") {
                    $userSpecialty = new UserSpecialty();
                    $userSpecialty->setUserId($user);
                    $specialty = $this->getDoctrine()->getRepository(Specialty::class)
                        ->findOneById($request->request->get('form')['specialties']);

                    $userSpecialty->setSpecialtyId($specialty);

                    $em = $this->getDoctrine()->getManager();

                    $em->persist($userSpecialty);
                    $em->flush();
                } else if($request->request->get('form')['custom_specialty'] != ""){
                    $userSpecialty = new UserSpecialty();
                    $specialty = new Specialty();
                    $specialty->setName($request->request->get('form')['custom_specialty']);

//                    $userSpecialty->setUserId($user);
//                    $specialty = $this->getDoctrine()->getRepository(Specialty::class)
//                        ->findOneById($request->request->get('form')['specialties']);
//
//                    $userSpecialty->setSpecialtyId($specialty);

                    $em = $this->getDoctrine()->getManager();

                    $em->persist($specialty);
                    $em->flush();

                    $userSpecialty->setUserId($user);
                    $userSpecialty->setSpecialtyId($specialty);
                    $em->persist($userSpecialty);
                    $em->flush();
                }
            }

            return $this->render('specialist/edit.html.twig', [
                'specialtiesForm' => $specialtiesForm->createView() ,
            ]);
        }

        return new RedirectResponse($urlGenerator->generate('app_login'));
    }

}