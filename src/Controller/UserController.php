<?php

namespace App\Controller;

use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("/user/settings", name="user_settings_show")
     * @param SymfonyRequest $request
     * @return RedirectResponse|Response
     */
    public function showSettings(SymfonyRequest $request)
    {
        $form = $this->createForm(UserFormType::class, $this->getUser());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();

            // TODO: Needs user change log - do it with event listeners
            $user = $this->getUser();
            $user->setFirstName($data->getFirstName());
            $user->setLastName($data->getLastName());
            $em->persist($user);
            $em->flush();
        }

        return $this->render("pages/user/settings.twig",[
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
        ]);
    }
}
