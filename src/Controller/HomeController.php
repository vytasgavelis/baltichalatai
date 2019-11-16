<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'someVariable' => 'NFQ Akademija',
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
     * @Route("/doctor/edit", name="doctor_edit")
     */
    public function doctor_edit()
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
     * @Route("/patient/edit", name="patient_edit")
     */
    public function patient_edit()
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
     * @Route("/clinic/edit", name="clinic_edit")
     */
    public function clinic_edit()
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
