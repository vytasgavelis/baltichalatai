<?php

namespace App\Controller;

use App\Entity\ClinicInfo;
use App\Entity\UserInfo;
use App\Entity\UserVisit;
use App\Form\ClinicInfoType;
use App\Form\UserInfoType;
use App\Services\UserInfoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Services\ClinicInfoService;
use Symfony\Component\Security\Core\User\UserInterface;

class ClinicController extends AbstractController
{

    /**
     * @var FlashBagInterface
     */
    private $bag;

    /**
     * @var ClinicInfoService
     */
    private $clinicInfoService;

    /**
     * ClinicController constructor.
     * @param ClinicInfoService $clinicInfoService
     * @param FlashBagInterface $bag
     */
    public function __construct(ClinicInfoService $clinicInfoService, FlashBagInterface $bag)
    {
        $this->clinicInfoService = $clinicInfoService;
        $this->bag = $bag;
    }

    /**
     * @Route("/clinic", name="clinic")
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserInterface|null $user
     * @return RedirectResponse|Response
     */
    public function index(UrlGeneratorInterface $urlGenerator, UserInterface $user = null)
    {
        if ($user instanceof User && $user->getRole() == 3) {
            if ($user->getClinicInfo() == null) {
                return new RedirectResponse($urlGenerator->generate('clinic_edit'));
            }
            return $this->render('clinic/home.html.twig', [
                'clinicInfo' => $user->getClinicInfo(),
            ]);
        }
        throw $this->createNotFoundException();
    }

    /**
     * @Route("/clinic/show/{id}", name="clinic_show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        $clinic = $this->getDoctrine()->getRepository(User::class)
            ->findByIdAndRole($id, 3);
        if (sizeof($clinic) == 0) {
            throw $this->createNotFoundException();
        }
        return $this->render('clinic/index.html.twig', [
            'clinic' => $clinic[0],
        ]);
    }

    /**
     * @Route("/clinic/edit", name="clinic_edit")
     * @return Response
     */
    public function edit(Request $request, UrlGeneratorInterface $urlGenerator, UserInterface $user = null)
    {
        if ($user instanceof User && $user->getRole() == 3) {
            $clinicInfo = $user->getClinicInfo();
            if (is_null($clinicInfo)) {
                $clinicInfo = new ClinicInfo();
            }
            $form = $this->createForm(ClinicInfoType::class, $clinicInfo, [
                'action' => $this->generateUrl('clinic_edit')
            ]);

            //Handle the request
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid() &&
                $this->clinicInfoService->validateClinicInfoForm($request->request->get('clinic_info')) == "") {
                $clinicInfo->setUserId($user);
                $em = $this->getDoctrine()->getManager();

                $em->persist($clinicInfo);
                $em->flush();

                $this->bag->add('success', 'Jūsų informacija buvo išsaugota.');

                return new RedirectResponse($urlGenerator->generate('clinic'));
            } else {
                return $this->render('clinic/edit.html.twig', [
                    'clinic_info_form' => $form->createView(),
                ]);
            }
        }

        throw $this->createNotFoundException();
    }
}
