<?php

namespace App\Controller;

use App\Entity\Request;
use App\Entity\Team;
use App\Entity\TeamMemberRequests;
use App\Entity\TeamMembers;
use App\Entity\User;
use App\Exceptions\InvalidMemberRoleException;
use App\Exceptions\Requests\InvalidRequestActionException;
use App\Exceptions\User\InvalidUserRoleException;
use App\Exceptions\User\InvalidUserStatusException;
use App\Form\NewRequestType;
use App\Validator\Teams\CanEditTeam;
use App\Validator\Teams\IsValidTeam;
use App\Validator\Teams\TeamEditor;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestsController extends AbstractController
{

    /**
     * @Route("/requests/approve/{teamId}/{userId}", name="approve_request")
     * @IsGranted("ROLE_NORMAL")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param ValidatorInterface $validator
     * @param int $teamId
     * @param int $userId
     * @return JsonResponse
     * @throws InvalidRequestActionException|InvalidMemberRoleException
     * @throws InvalidUserStatusException
     * @throws InvalidUserRoleException
     */
    public function approveMember(\Symfony\Component\HttpFoundation\Request $request, ValidatorInterface $validator, int $teamId, int $userId)
    {
        $response = $validator->validate([
            'editor_id' => $this->getUser()->getId(),
            'user_id' => $userId,
            'team_id' => $teamId,
        ], [
            new IsValidTeam(),
            new CanEditTeam(),
        ]);

        if (count($response) > 0) {
            return new JsonResponse([
                'success' => false,
                'message' => $response[0]->getMessage(),
            ]);
        }

        $em = $this->getDoctrine()->getManager();

        $requestingMember = $em->getRepository(TeamMemberRequests::class)->findOneBy(['userId' => $userId, 'teamId' => $teamId,]);
        $requestingMember->setActionTo(TeamMemberRequests::ACTION_ACCEPTED);
        $requestingMember->setUpdatedBy($this->getUser()->getId());
        $em->remove($requestingMember);
        $em->flush();


        $team = $em->getRepository(Team::class)->findOneBy(['id' => $teamId]);
        $user = $em->getRepository(User::class)->findOneBy(['id' => $userId]);

        $member = new TeamMembers();
        $member->setRole(TeamMembers::ROLE_MEMBER);
        $member->setTeam($team);
        $member->setUser($user);
        $member->setJoinedOn(new DateTime());
        $em->persist($member);


        /***
         * TODO: Handle this with a new TeamMemberRequest event listener, something like that in the future update
         */
        $user->setStatus(User::USER_STATUS_ACTIVE);
        $user->setRole(User::ROLE_NORMAL);
        $em->persist($user);
        $em->flush();


        return new JsonResponse([
            'success' => true,
            'message' => "You have successfully added member to the team."
        ]);
    }

    /**
     * @Route("/requests", name="requests")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response
     */
    public function index(\Symfony\Component\HttpFoundation\Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $requests = $em->getRepository(Request::class)->findBy(
            ['user_id' => $this->getUser()->getId()],
            ['createdOn' => 'DESC']
        );

        $domain = new Request();
        $domain->setCreatedOn(new DateTime());
        $form = $this->createForm(NewRequestType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $data->setUserId($this->getUser()->getId());
            $data->setCreatedOn(new DateTime());
            $data->setUpdatedBy($this->getUser()->getId());
            $em->persist($data);
            $em->flush();

            return $this->render("pages/dashboard/requests.twig", [
                'requests' => $requests,
                'form' => $form->createView(),
                'success' => true,
            ]);
        }

        return $this->render("pages/dashboard/requests.twig", [
            'requests' => $requests,
            'form' => $form->createView(),
            'success' => false,
        ]);
    }
}
