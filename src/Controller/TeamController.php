<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\TeamMembers;
use App\Exceptions\InvalidMemberRoleException;
use App\Form\NewTeamFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{

    /**
     * @Route("/teams/apply_for_a_team", name="teams_apply")
     * @param Request $request
     * @return JsonResponse
     */
    public function applyForATeam(Request $request): JsonResponse
    {

        return new JsonResponse([
            'success' => true,
        ]);
    }

    /**
     * @Route("/no_team", name="app_pending")
     * @IsGranted("ROLE_PENDING")
     */
    public function showPendingMessage()
    {
        // TODO: Needs a check if user is already in team
        return $this->render("pages/teams/no_team.twig");
    }

    /**
     * @Route("/teams/show_all", name="teams_show_all")
     * @IsGranted("ROLE_PENDING")
     */
    public function show_all()
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository(Team::class)->findAll();

        return new JsonResponse([
            'success' => true,
            'data' => $this->renderView('partials/teams/all_teams.twig', [
                'teams' => $teams,
            ]),
        ]);
    }

    /**
     * @Route("/teams/new", name="teams_new")
     * @param Request $request
     * @return Response
     * @throws InvalidMemberRoleException
     * @IsGranted("ROLE_PENDING")
     */
    public function new_team(Request $request)
    {
        $success = false;
        $team = new Team();
        
        $form = $this->createForm(NewTeamFormType::class, $team);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $teamEntity = $form->getData();
            $entityManager->persist($teamEntity);
            $entityManager->flush();

            $members = new TeamMembers();
            $members->setTeam($teamEntity);
            $members->setRole(TeamMembers::ROLE_FOUNDER);
            $members->setUser($this->getUser());
            $entityManager->persist($members);
            $entityManager->flush();
            $success = true;
        }

        return $this->render('partials/forms/new_team.twig', [
            'form' => $form->createView(),
            'success' => $success
        ]);
    }

    /**
     * @Route("/teams/my_team", name="team_my_team")
     * @IsGranted("ROLE_NORMAL")
     */
    public function showTeam()
    {
        /** @var $em */
        $em = $this->getDoctrine()->getManager();

        $userTeam = $em->getRepository(TeamMembers::class)->findOneBy([
            'userId' => $this->getUser()->getId()
        ]);

        return $userTeam instanceof TeamMembers ?
            $this->render('pages/teams/my_team.twig', ['team' => $userTeam->getTeam()]) :
            new RedirectResponse("/dashboard");
    }
}
