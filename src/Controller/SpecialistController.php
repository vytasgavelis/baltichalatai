<?php
namespace App\Controller;
use App\Entity\SpecialistWorkHours;
use App\Entity\User;
use App\Entity\UserInfo;
use App\Form\UserInfoType;
use App\Services\SpecialistService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SpecialistController extends AbstractController
{
    private $specialistService;
    public function __construct(SpecialistService $specialistService)
    {
        $this->specialistService = $specialistService;
    }
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
            ->findByIdAndRole($id, 2);
        if (sizeof($specialist) == 0) {
            throw $this->createNotFoundException();
        } else {
            $workHours = $this->getDoctrine()->getRepository(SpecialistWorkHours::class)
                ->getWorkHours($specialist[0]);
        }
        return $this->render('specialist/index.html.twig', [
            'specialist' => $specialist[0],
            'workHours' => $this->specialistService->getSpecialistHoursFormatted($workHours),
        ]);
    }

}