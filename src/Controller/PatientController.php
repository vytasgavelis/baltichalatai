<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    /**
     * @Route("/patient", name="patient")
     */
    public function index()
    {
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }

    /**
     * @Route("/patient/{id}", name="patient_show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
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
}
