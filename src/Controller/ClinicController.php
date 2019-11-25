<?php

namespace App\Controller;

use App\Entity\ClinicInfo;
use App\Entity\UserInfo;
use App\Form\ClinicInfoType;
use App\Form\UserInfoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @Route("/clinic/show/{id}", name="clinic_show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        $clinic = $this->getDoctrine()->getRepository(User::class)
            ->findByIdAndRole($id, 3);
        if (sizeof($clinic) == 0) {
            $clinic = null;
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

            if ($form->isSubmitted() && $form->isValid()) {
                $clinicInfo->setUserId($user);
                $em = $this->getDoctrine()->getManager();

                $em->persist($clinicInfo);
                $em->flush();
            }

            return $this->render('clinic/edit.html.twig', [
                'clinic_info_form' => $form->createView()
            ]);
        }

        return new RedirectResponse($urlGenerator->generate('app_login'));
    }

}
