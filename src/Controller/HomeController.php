<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/error", name="404")
     */
    public function error()
    {
        return $this->render('home/error.html.twig');
    }
}
