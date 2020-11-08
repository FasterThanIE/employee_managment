<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Route("/home", name="home_")
     * @Route("/dashboard", name="dashboard")
     * @Security("is_granted('ROLE_NORMAL') or is_granted('ROLE_PENDING')")
     */
    public function dashboard(): Response
    {
        return $this->isGranted("ROLE_PENDING") ?
            $this->render("pages/teams/no_team.twig"):
            $this->render("pages/dashboard/home.twig");
    }
}
