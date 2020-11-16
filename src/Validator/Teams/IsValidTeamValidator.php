<?php

namespace App\Validator\Teams;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsValidTeamValidator extends ConstraintValidator
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

        $teamId = $value['team_id'];

        $team = $this->em->getRepository(Team::class)->findOneBy(['id' => $teamId]);

        if ($team instanceof Team) {
            return;
        }

        $this->context->buildViolation("Invalid team team id: " . $teamId)
            ->setParameter('{{ value }}', 'team_id')
            ->addViolation();
    }
}
