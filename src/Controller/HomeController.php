<?php

namespace App\Controller;

use App\Entity\TeamMemberRequests;
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
        if($this->isGranted("ROLE_PENDING"))
        {
            $em = $this->getDoctrine()->getManager();

            $teamRequests = $em->getRepository(TeamMemberRequests::class)->findOneBy(['userId' => $this->getUser()->getId()]);

            return $teamRequests ?
                $this->render("pages/teams/pending_accept.twig", ['team' => $teamRequests->getTeam()]) :
                $this->render("pages/teams/no_team.twig");
        }

        return $this->render("pages/dashboard/home.twig");
    }
}
