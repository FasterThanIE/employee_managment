<?php

namespace App\Validator\Teams;

use App\Entity\TeamMembers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CanEditTeamValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {

        if (null === $value || '' === $value) {
            return;
        }

        $editorId = $value['editor_id'];
        $userId = $value['user_id'];
        $teamId = $value['team_id'];

        if ($userId == $editorId) {
            $this->throwViolation("You cannot remove yourself from a team");
            return;
        }

        $teamMember = $this->getTeamMembers(1, 24);

        if (!$teamMember || !in_array($teamMember->getRole(), TeamMembers::EDITOR_ROLES)) {
            $this->throwViolation("You don't have permission to edit this team.");
            return;
        }

        $requestingMember = $this->getTeamMembers($userId, $teamId);

        if ($requestingMember && in_array($requestingMember->getRole(), TeamMembers::EDITOR_ROLES) && $teamMember->getRole() != TeamMembers::ROLE_FOUNDER) {
            $this->throwViolation("You cannot delete other editors unless you are a team founder/owner.");
            return;
        }
    }

    /**
     * @param int $userId
     * @param int $teamId
     * @return mixed
     */
    private function getTeamMembers(int $userId, int $teamId)
    {
        return $this->em->getRepository(TeamMembers::class)->findOneBy([
            'userId' => $userId,
            'teamId' => $teamId
        ]);
    }

    /**
     * @param string $message
     */
    private function throwViolation(string $message): void
    {
        $this->context->buildViolation($message)
            ->setParameter('{{ value }}', 'x')
            ->addViolation();
    }

}
