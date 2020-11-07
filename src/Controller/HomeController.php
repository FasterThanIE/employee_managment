<?php

namespace App\Controller;

use App\Security\Voter\StatusCheckVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Route("/home", name="home_")
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        $this->denyAccessUnlessGranted(StatusCheckVoter::USER_PENDING,$this->getUser());

        return $this->render("pages/dashboard/home.twig");
    }
}
