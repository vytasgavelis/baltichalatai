<?php

namespace App\Controller;

use App\Entity\SpecialistWorkHours;
use App\Services\SpecialistService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $specialist = $this->specialistService->getSpecialist($id);
        if (sizeof($specialist) == 0) {
            throw $this->createNotFoundException();
        } else {
            $workHours = $this->specialistService->getSpecialistWorkHours($specialist[0]);
        }

        return $this->render('specialist/index.html.twig', [
            'specialist' => $specialist[0],
            'workHours' => $this->specialistService->getSpecialistHoursFormatted($workHours),
        ]);
    }

    /**
     * @Route("/specialist/{id}/hours_edit", name="specialist_hours_edit")
     * @param $id
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function editHours($id, Request $request)
    {
        if (!is_null($request->get('day'))) {
            $manager = $this->getDoctrine()->getManager();

            $specialist = $this->specialistService->getSpecialist($id);
            $clinic = $this->specialistService->getClinic($request->get('clinicId'));

            $workHours = $this->specialistService->getWorkHours($id, $clinic[0]->getId());
            foreach ($workHours as $workHour) { //ismetam visus laikus
                $manager->remove($workHour);
            }
            foreach ($request->get('day') as $key => $day) {
                //praskipinam jeigu nieko neideta, kad nesugeneruotu default laiku
                if ($day['startTime'] == "" || $day['endTime'] == "") {
                    continue;
                }
                $workHours = new SpecialistWorkHours(); //sudedam naujus laikus
                $workHours->setClinicId($clinic[0]);
                $workHours->setSpecialistId($specialist[0]);
                $workHours->setDay($key);
                $workHours->setStartTime(new DateTime($day['startTime']));
                $workHours->setEndTime(new DateTime($day['endTime']));

                $manager->persist($workHours);
            }
            $manager->flush();
        }

        $specialist = $this->specialistService->getSpecialist($id);
        if (sizeof($specialist) == 0) {
            throw $this->createNotFoundException();
        }

        $workHours = $this->specialistService->getSpecialistWorkHours($specialist[0]);
        $specClinics = $this->specialistService->getSpecialistClinics($id);

        return $this->render('specialist/hours_edit.html.twig', [
            'workDayList' => $this->specialistService->getWorkdayList(),
            'specClinics' => $specClinics,
            'workHours' => $workHours,
        ]);
    }
}
