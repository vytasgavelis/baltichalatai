<?php

namespace App\Controller;

use App\Entity\SpecialistWorkHours;
use App\Services\SpecialistService;
use App\Services\UserSpecialtyService;
use App\Entity\UserVisit;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Specialty;
use App\Entity\User;
use App\Entity\UserSpecialty;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
    /**
     * @var UserSpecialtyService
     */
    private $userSpecialtyService;

    public function __construct(SpecialistService $specialistService, UserSpecialtyService $userSpecialtyService)
    {
        $this->specialistService = $specialistService;
        $this->userSpecialtyService = $userSpecialtyService;
    }

    /**
     * @Route("/specialist", name="specialist")
     */
    public function index(UrlGeneratorInterface $urlGenerator, UserInterface $user = null)
    {
        if (is_bool($user->getUserInfo()->first())) {
            return new RedirectResponse($urlGenerator->generate('userinfo_edit'));
        }

        $workHours = $this->specialistService->getSpecialistWorkHours($user);

        $specClinics = $this->specialistService->getSpecialistClinics($user->getId());
        return $this->render('specialist/home.html.twig', [
            'userInfo' => $user->getUserInfo()->first(),
            'visits' => $this->getDoctrine()->getRepository(UserVisit::class)->findBySpecialistId($user->getId()),
            'workDayList' => $this->specialistService->getWorkdayList(),
            'specClinics' => $specClinics,
            'workHours' => $workHours,
        ]);
    }

    /**
     * @Route("/specialist/show/{id}", name="specialist_show")
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $specialist = $this->specialistService->getSpecialist($id);
        if (sizeof($specialist) == 0) {
            throw $this->createNotFoundException();
        } else {
            $workHours = $this->specialistService->getSpecialistWorkHours($specialist[0]);
        }

        return $this->render('specialist/index.html.twig', [
            'specialist' => $specialist[0],
            'workHours' => $this->specialistService->getSpecialistHoursFormatted($workHours),
        ]);
    }

    /**
     * @Route("/specialist/hours_edit", name="specialist_hours_edit")
     * @param Request $request
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserInterface|null $user
     * @return Response
     * @throws \Exception
     */
    public function editHours(Request $request, UrlGeneratorInterface $urlGenerator, UserInterface $user = null)
    {
        if ($user instanceof User && $user->getRole() == 2) {
            if (!is_null($request->get('day'))) {
                $manager = $this->getDoctrine()->getManager();

                $clinic = $this->specialistService->getClinic($request->get('clinicId'));

                $workHours = $this->specialistService->getWorkHours($user->getId(), $clinic[0]->getId());
                foreach ($workHours as $workHour) { //ismetam visus laikus
                    $manager->remove($workHour);
                }
                foreach ($request->get('day') as $key => $day) {
                    //praskipinam jeigu nieko neideta, kad nesugeneruotu default laiku
                    if ($day['startTime'] == "" || $day['endTime'] == "") {
                        continue;
                    }
                    $workHours = new SpecialistWorkHours(); //sudedam naujus laikus
                    $workHours->setClinicId($clinic[0]);
                    $workHours->setSpecialistId($user);
                    $workHours->setDay($key);
                    $workHours->setStartTime(new DateTime($day['startTime']));
                    $workHours->setEndTime(new DateTime($day['endTime']));

                    $manager->persist($workHours);
                }
                $manager->flush();
            }
            return new RedirectResponse($urlGenerator->generate('specialist'));
            $workHours = $this->specialistService->getSpecialistWorkHours($user);

            $specClinics = $this->specialistService->getSpecialistClinics($user->getId());
            return $this->render('specialist/hours_edit.html.twig', [
                'workDayList' => $this->specialistService->getWorkdayList(),
                'specClinics' => $specClinics,
                'workHours' => $workHours,
            ]);
        }
        throw $this->createNotFoundException('Puslapis nerastas');
    }

    /**
     * @Route("/specialist/edit", name="specialist_edit")
     * @param Request $request
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserInterface|null $user
     * @return Response
     */
    public function edit(Request $request, UrlGeneratorInterface $urlGenerator, UserInterface $user = null)
    {
        if ($user instanceof User && $user->getRole() == 2) {
            $specialtiesForm = $this->createSpecialistForm();
            $specialtiesForm->handleRequest($request);

            if ($specialtiesForm->isSubmitted() && $specialtiesForm->isValid()) {
                $responseData = $request->request->get('form');
                $this->userSpecialtyService->addSpecialty(
                    $responseData['specialties'],
                    $responseData['custom_specialty'],
                    $user
                );
            }

            return $this->render('specialist/edit.html.twig', [
                'specialtiesForm' => $specialtiesForm->createView(),
            ]);
        }

        return new RedirectResponse($urlGenerator->generate('app_login'));
    }

    private function createSpecialistForm(UserInterface $user = null)
    {
        $specialties = $this->getDoctrine()->getRepository(Specialty::class)->findAll();
        $choices = array();
        foreach ($specialties as $specialty) {
            $choices += array($specialty->getName() => $specialty->getId());
        }

        $specialtiesForm = $this->createFormBuilder([])
            ->add('specialties', ChoiceType::class, [
                'choices' => $choices,
                'required' => false,
            ])
            ->add('custom_specialty', TextType::class, ['required' => false])
            ->add('submit', SubmitType::class, ['label' => 'Prideti'])
            ->getForm();

        return $specialtiesForm;
    }
}
