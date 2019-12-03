<?php

namespace App\Controller;

use App\Entity\UserVisit;
use App\Services\UserVisitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVisitController extends AbstractController
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var UserVisitService
     */
    private $visitService;
    /**
     * @var FlashBagInterface
     */
    private $bag;

    /**
     * UserVisitController constructor.
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserVisitService $visitService
     * @param FlashBagInterface $bag
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        UserVisitService $visitService,
        FlashBagInterface $bag
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->visitService = $visitService;
        $this->bag = $bag;
    }

    /**
     * @Route("/uservisit/{id}/delete", name="delete_user_visit")
     * @param UserVisit $userVisit
     * @param UserInterface $user
     * @return RedirectResponse
     */
    public function deleteUserVisit(
        UserVisit $userVisit,
        UserInterface $user
    ) {
        if ($user->getId() == $userVisit->getClientId()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userVisit);
            $em->flush();

            return new RedirectResponse($this->urlGenerator->generate('patient'));
        } elseif ($user->getId() == $userVisit->getSpecialistId()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userVisit);
            $em->flush();

            return new RedirectResponse($this->urlGenerator->generate('specialist'));
        }

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }

    /**
     * @Route ("/uservisit/{id}/close", name="close_visit")
     * @param UserVisit $userVisit
     * @param UserInterface $user
     * @return RedirectResponse
     */
    public function closeVisit(UserVisit $userVisit, UserInterface $user)
    {
        if ($user->getId() == $userVisit->getClientId()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $userVisit->setIsCompleted(true);
            $em->flush();

            $this->bag->add('success', 'Vizitas uždarytas');

            return new RedirectResponse($this->urlGenerator->generate('patient'));
        } elseif ($user->getId() == $userVisit->getSpecialistId()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $userVisit->setIsCompleted(true);
            $em->flush();

            $this->bag->add('success', 'Vizitas uždarytas');

            return new RedirectResponse($this->urlGenerator->generate('specialist'));
        }

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}
