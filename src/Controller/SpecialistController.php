<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpecialistController extends AbstractController
{
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
     * @Route("/specialist/{id}", name="specialist_show")
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $specialist = $this->getDoctrine()->getRepository(User::class)
            ->findByIdAndRole($id, 1);
        if (sizeof($specialist) == 0) {
            $specialist = null;
        }
        return $this->render('specialist/index.html.twig', [
            'specialist' => $specialist[0],
        ]);
    }
}
