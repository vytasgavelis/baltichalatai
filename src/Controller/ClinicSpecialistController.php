<?php

namespace App\Controller;

use App\Entity\ClinicSpecialists;
use App\Services\ClinicSpecialistService;
use App\Services\SpecialistService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class ClinicSpecialistController extends AbstractController
{
    /**
     * @var ClinicSpecialistService
     */
    private $clinicSpecialistService;

    /**
     * @var SpecialistService
     */
    private $specialistService;

    public function __construct(ClinicSpecialistService $clinicSpecialistService, SpecialistService $specialistService)
    {
        $this->clinicSpecialistService = $clinicSpecialistService;
        $this->specialistService = $specialistService;
    }

    /**
     * @Route("/clinicspecialist/{id}/add", name="clinic_specialist_add")
     * @param UrlGeneratorInterface $urlGenerator
     * @param User $specialist
     * @param UserInterface|null $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(UrlGeneratorInterface $urlGenerator, User $specialist, UserInterface $user = null)
    {
        if ($user instanceof User && $user->getRole() == 3) {
            $this->clinicSpecialistService->addSpecialist($user, $specialist);
        }
        return new RedirectResponse($urlGenerator->generate('specialist_show', ['id' => $specialist->getId()]));
    }

    /**
     * @Route("/clinicspecialist/{id}/remove", name="clinic_specialist_remove")
     * @param UrlGeneratorInterface $urlGenerator
     * @param User $specialist
     * @param UserInterface|null $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function remove(UrlGeneratorInterface $urlGenerator, User $specialist, UserInterface $user = null)
    {
        if ($user instanceof User && $user->getRole() == 3) {
            $em = $this->getDoctrine()->getManager();
            $this->specialistService->removeSpecialistWorkHours($specialist, $user);
            $clinicSpecialists = $em->getRepository(ClinicSpecialists::class)
                ->findBySpecialistIdAndClinicId($specialist->getId(), $user->getId());
            $em->remove($clinicSpecialists[0]);
            $em->flush();
        }
        return new RedirectResponse($urlGenerator->generate('specialist_show', ['id' => $specialist->getId()]));
    }

    /**
     * @Route("clinicspecialist/assignToNoClinic", name="assign_to_no_clinic")
     * @param UserInterface|null $user
     */
    public function assignSpecialistToNoClinic(UrlGeneratorInterface $urlGenerator, UserInterface $user = null)
    {
        if ($user instanceof User && $user->getRole() == 2) {
            $clinic = $this->clinicSpecialistService->getNoClinic();
            $clinicSpecialist = new ClinicSpecialists();
            $clinicSpecialist->setClinicId($clinic[0]);
            $clinicSpecialist->setSpecialistId($user);

            $this->getDoctrine()->getManager()->persist($clinicSpecialist);
            $this->getDoctrine()->getManager()->flush();

            return new RedirectResponse($urlGenerator->generate('specialist'));
        }
        throw $this->createNotFoundException();
    }
}
