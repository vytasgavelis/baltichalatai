<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\PatientServices;
use App\Services\UserVisitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PatientController extends AbstractController
{
    /**
     * @var PatientServices
     */
    private $patientServices;

    /**
     * PatientController constructor.
     * @param PatientServices $patientServices
     */
    public function __construct(PatientServices $patientServices)
    {
        $this->patientServices = $patientServices;
    }


    /**
     * @Route("/patient/show/{id}", name="patient_show")
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $patient = $this->getDoctrine()->getRepository(User::class)
            ->findByIdAndRole($id, 3);
        if (sizeof($patient) == 0) {
            $patient = null;
        }
        return $this->render('patient/index.html.twig', [
            'patient' => $patient[0],
        ]);
    }

    /**
     * @Route("/patient", name="patient")
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserInterface|null $user
     * @return Response
     */
    public function panel(UrlGeneratorInterface $urlGenerator, UserInterface $user = null)
    {
        if (is_bool($user->getUserInfo()->first())) {
            return new RedirectResponse($urlGenerator->generate('userinfo_edit'));
        }
        if ($user instanceof User && $user->getRole() == 1) {
            return $this->render('patient/home.html.twig', [
                'visits' => $user->getUserVisits(),
                'userInfo' => $user->getUserInfo()->first(),
                'clientRecipes' => $this->patientServices->getClientRecipes($user)
            ]);
        }

        return new RedirectResponse($urlGenerator->generate('app_login'));
    }
}
