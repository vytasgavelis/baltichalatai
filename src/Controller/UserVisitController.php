<?php

namespace App\Controller;

use App\Entity\UserVisit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVisitController extends AbstractController
{
    /**
     * @Route("/uservisit/{id}/delete", name="delete_user_visit")
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserVisit $userVisit
     * @param UserInterface|null $user
     * @return RedirectResponse
     */
    public function deleteUserVisit(
        UrlGeneratorInterface $urlGenerator,
        UserVisit $userVisit,
        UserInterface $user = null
    ) {
        if ($user->getId() == $userVisit->getClientId()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userVisit);
            $em->flush();
            return new RedirectResponse($urlGenerator->generate('patient'));
        } elseif ($user->getId() == $userVisit->getSpecialistId()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userVisit);
            $em->flush();
            return new RedirectResponse($urlGenerator->generate('specialist'));
        }
        return new RedirectResponse($urlGenerator->generate('app_login'));
    }
}
