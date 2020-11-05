<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("/user/settings", name="user_settings_show")
     */
    public function showSettings()
    {
        $form = $this->createForm(UserFormType::class, $this->getUser());
        return $this->render("pages/user/settings.twig",[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/settings/save", name="user_settings_save", methods={"POST"})
     * @param SymfonyRequest $request
     * @return RedirectResponse
     */
    public function saveSettings(SymfonyRequest $request)
    {
        $domain = new User();

        $form = $this->createForm(UserFormType::class, $domain);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();

            $user = $this->getUser();
            $user->setFirstName($data->getFirstName());
            $user->setLastName($data->getLastName());
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_settings_show',[
                'message' => "You have saved your account.",
            ]);
        }

        return $this->redirectToRoute('user_settings_show',[
            'message' => "There was an error while saving your account.",
        ]);
    }
}
