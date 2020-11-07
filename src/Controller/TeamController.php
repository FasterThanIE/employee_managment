<?php

namespace App\Controller;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    /**
     * @Route("/teams/show_all", name="teams_show_all")
     */
    public function show_all()
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository(Team::class)->findAll();

        return new JsonResponse([
            'success' => true,
            'data' => $this->renderView('pages/teams/all_teams.twig', [
                'teams' => $teams
            ]),
        ]);
    }
}
