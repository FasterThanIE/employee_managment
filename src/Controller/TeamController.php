<?php

namespace App\Controller;

use App\Entity\Log\TeamActionLog;
use App\Entity\Logs\TeamMemberRequestsLog;
use App\Entity\Team;
use App\Entity\TeamMemberRequests;
use App\Entity\TeamMembers;
use App\Exceptions\InvalidRequestStatusException;
use App\Form\NewTeamFormType;
use DateTime;
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
     * @IsGranted("ROLE_PENDING")
     * @throws InvalidRequestStatusException
     */
    public function applyForATeam(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $userRequests = $em->getRepository(TeamMemberRequests::class)->findOneBy(['userId' => $this->getUser()->getId()]);
        $team = $em->getRepository(Team::class)->find(['id' => $request->get('team_id')]);

        if ($userRequests || !$team) {
            return new JsonResponse([
                'success' => false,
            ]);
        }

        $memberRequests = new TeamMemberRequests();
        $memberRequests->setUser($this->getUser());
        $memberRequests->setTeam($team);
        $em->persist($memberRequests);
        $em->flush();

        // TODO: Handle TeamMemberRequestLog using the event listener. Ex: postUpdate? postPersist?
        $requestLog = new TeamMemberRequestsLog();
        $requestLog->setUserId($this->getUser()->getId());
        $requestLog->setTeamId($team->getId());
        $requestLog->setAppliedOn(new DateTime());
        $requestLog->setStatus(TeamMemberRequestsLog::STATUS_PENDING);
        $requestLog->setRequestId($memberRequests->getId());
        $em->persist($requestLog);
        $em->flush();

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
     * @IsGranted("ROLE_PENDING")
     */
    public function new_team(Request $request)
    {
        $team = new Team();

        $form = $this->createForm(NewTeamFormType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $teamEntity = $form->getData();
            $teamEntity->setUser($this->getUser());
            $teamEntity->setAction(TeamActionLog::ACTION_CREATED);

            $entityManager->persist($teamEntity);
            $entityManager->flush();

            return new JsonResponse([
                'success' => true
            ]);
        }

        return $this->render('partials/forms/new_team.twig', [
            'form' => $form->createView(),
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
