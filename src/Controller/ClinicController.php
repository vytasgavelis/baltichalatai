<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class ClinicController extends AbstractController
{
    /**
     * @Route("/clinic", name="clinic")
     */
    public function index()
    {
        return $this->render('clinic/index.html.twig', [
            'controller_name' => 'ClinicController',
        ]);
    }

    /**
     * @Route("/clinic/{id}", name="clinic_show")
     */
    public function show($id)
    {
        $clinic = $this->getDoctrine()->getRepository(User::class)
            ->findByIdAndRole($id, 2);
        if(sizeof($clinic) == 0){
            $clinic = null;
        }
        return $this->render('clinic/index.html.twig', [
            'clinic' => $clinic[0],
        ]);
    }
}
