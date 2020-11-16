<?php

namespace App\Controller;

use App\Entity\Log\TeamActionLog;
use App\Entity\Team;
use App\Entity\TeamMemberRequests;
use App\Entity\TeamMembers;
use App\Exceptions\Requests\InvalidRequestActionException;
use App\Form\NewTeamFormType;
use Doctrine\ODM\MongoDB\DocumentManager;
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
     * @var DocumentManager
     */
    private $dm;


    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * @Route("/teams/apply_for_a_team", name="teams_apply")
     * @param Request $request
     * @return JsonResponse
     * @IsGranted("ROLE_PENDING")
     * @throws InvalidRequestActionException
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
        $memberRequests->setActionTo(TeamMemberRequests::ACTION_PENDING);
        $memberRequests->setUpdatedBy($this->getUser()->getId());
        $em->persist($memberRequests);
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
            $this->render('pages/teams/my_team.twig', [
                'team' => $userTeam->getTeam(),
                'editor' => in_array($userTeam->getRole(), TeamMembers::EDITOR_ROLES),
            ]) :
            new RedirectResponse("/dashboard");
    }


    /**
     * @Route("/teams/remove_member/{userId}/{teamId}",
     *     name="team_remove_member",
     *     methods={"POST"},
     *     requirements={"user_id" = "\d+", "team_id" = "\d+", "x"="\d+"}
     * )
     * @IsGranted("ROLE_NORMAL")
     * @param Request $request
     * @return JsonResponse
     */
    public function removeMember(Request $request, int $userId, int $teamId): JsonResponse
    {
        if ($userId == $this->getUser()->getId()) {
            return new JsonResponse([
                'success' => false,
                'message' => "You cannot add/remove yourself from a team"
            ]);
        }
        $em = $this->getDoctrine()->getManager();

        $teamMember = $em->getRepository(TeamMembers::class)->findOneBy([
            'userId' => $this->getUser()->getId(),
            'teamId' => $teamId
        ]);

        if (!in_array($teamMember->getRole(), TeamMembers::EDITOR_ROLES)) {
            return new JsonResponse([
                'success' => false,
                'message' => "You don't have permission to edit this team."
            ]);
        }

        $requestingMember = $em->getRepository(TeamMembers::class)->findOneBy([
            'userId' => $userId,
            'teamId' => $teamId
        ]);

        if (!$requestingMember) {
            return new JsonResponse([
                'success' => false,
                'message' => "This user is not part of this team."
            ]);
        }

        if (in_array($requestingMember, TeamMembers::EDITOR_ROLES) && $teamMember->getRole() != TeamMembers::ROLE_FOUNDER) {
            return new JsonResponse([
                'success' => false,
                'message' => "You cannot delete other editors unless you are a team founder/owner."
            ]);
        }

        $em->remove($requestingMember);
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => "You have successfully removed member from the team."
        ]);
    }
}
