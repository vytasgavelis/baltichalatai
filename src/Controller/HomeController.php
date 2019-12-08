<?php

namespace App\Controller;

use App\Entity\Specialty;
//use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
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

    /**
     * @Route("/about", name="about")
     */
    public function about(){
        return $this->render('home/about.html.twig');
    }
}
