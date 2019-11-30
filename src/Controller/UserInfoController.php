<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserInfo;
use App\Form\UserInfoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserInfoController extends AbstractController
{

    /**
     * @Route("/userinfo/edit", name="userinfo_edit")
     * @param Request $request
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserInterface|null $user
     * @return Response
     */
    public function edit(Request $request, UrlGeneratorInterface $urlGenerator, UserInterface $user = null)
    {
        if ($user instanceof User && ($user->getRole() == 2 || $user->getRole() == 1)) {
            $message = null;
            $userInfo = $user->getUserInfo()->first();
            if ($userInfo == false) {
                $userInfo = new UserInfo();
                $message = 'Prašome užpildyti asmeninę informaciją';
            }
            $form = $this->createForm(UserInfoType::class, $userInfo, [
                'action' => $this->generateUrl('userinfo_edit'),
            ]);

            //Handle the request
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $userInfo->setUserId($user);
                $em = $this->getDoctrine()->getManager();

                $em->persist($userInfo);
                $em->flush();
                if($user->getRole() == 1) {
                    return new RedirectResponse($urlGenerator->generate('patient'));
                } else {
                    return new RedirectResponse($urlGenerator->generate('specialist'));
                }
            } else {
                return $this->render('user_info/edit.html.twig', [
                    'message' => $message,
                    'user_info_form' => $form->createView(),
                ]);
            }
            return $this->render('user_info/edit.html.twig', [
                'message' => $message,
                'user_info_form' => $form->createView(),
            ]);
        }

        return new RedirectResponse($urlGenerator->generate('app_login'));
    }
}
