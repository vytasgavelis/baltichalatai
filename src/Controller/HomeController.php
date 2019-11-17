<?php

namespace App\Controller;

use App\Entity\Specialty;
//use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/asd", name="home")
     */
    public function index()
    {
        $specialties = $this->getDoctrine()->getRepository(Specialty::class)->findAll();
        return $this->render('home/index.html.twig', [
            'specialties' => $specialties,
            'is_logged_in' => false,
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register()
    {
        return $this->render('home/register.html.twig', [
            'someVariable' => 'NFQ Akademija',
            'is_logged_in' => false,
        ]);
    }
    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('home/login.html.twig', [
            'someVariable' => 'NFQ Akademija',
            'is_logged_in' => false,
        ]);
    }
    /**
     * @Route("/doctor", name="doctor")
     */
    public function doctor()
    {
        return $this->render('home/doctor.html.twig', [
            'someVariable' => 'NFQ Akademija',
            'is_logged_in' => false,
            'edit' => false,
        ]);
    }
    /**
     * @Route("/doctor/edit", name="doctorEdit")
     */
    public function doctorEdit()
    {
        return $this->render('home/doctor.html.twig', [
            'someVariable' => 'NFQ Akademija',
            'is_logged_in' => false,
            'edit' => true,
        ]);
    }
    /**
     * @Route("/patient", name="patient")
     */
    public function patient()
    {
        return $this->render('home/patient.html.twig', [
            'someVariable' => 'NFQ Akademija',
            'is_logged_in' => false,
            'edit' => false,
        ]);
    }
    /**
     * @Route("/patient/edit", name="patientEdit")
     */
    public function patientEdit()
    {
        return $this->render('home/patient.html.twig', [
            'someVariable' => 'NFQ Akademija',
            'is_logged_in' => false,
            'edit' => true,
        ]);
    }
    /**
     * @Route("/clinic", name="clinic")
     */
    public function clinic()
    {
        return $this->render('home/clinic.html.twig', [
            'someVariable' => 'NFQ Akademija',
            'is_logged_in' => false,
            'edit' => false,
        ]);
    }
    /**
     * @Route("/clinic/edit", name="clinicEdit")
     */
    public function clinicEdit()
    {
        return $this->render('home/clinic.html.twig', [
            'someVariable' => 'NFQ Akademija',
            'is_logged_in' => false,
            'edit' => true,
        ]);
    }
    
    /**
     * @Route("/results", name="results")
     */
    public function results()
    {
        return $this->render('home/results.html.twig', [
            'search_results' => [
                'specialist' => [
                    'Šeimos gydytojas',
                    'Akių lygių spec',
                    'Traumatologas',
                    'Odontologas'
                ],
                'clinic' => [
                    'Šilainių Poliklinika',
                    'Dainavos Poliklinika',
                    'Šančių Poliklinika'
                ],
                'city' => ['Kaunas', 'Vilnius', 'Klaipėda'],
                'doctor' => ['Daktaras', 'Daktarė', 'Seselė']
            ],
            'is_logged_in' => false,
        ]);
    }
}
