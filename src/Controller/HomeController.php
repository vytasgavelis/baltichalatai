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
        $specialties = $this->getDoctrine()->getRepository(
            Specialty::class)->findAll();
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
}
