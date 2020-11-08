<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Route("/home", name="home_")
     * @Route("/dashboard", name="dashboard")
     * @IsGranted("ROLE_NORMAL")
     */
    public function dashboard(): Response
    {
        return $this->render("pages/dashboard/home.twig");
    }
}
