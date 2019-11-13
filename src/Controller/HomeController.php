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
