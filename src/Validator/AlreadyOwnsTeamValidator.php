<?php

namespace App\Validator;

use App\Entity\TeamMembers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AlreadyOwnsTeamValidator extends ConstraintValidator
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var TokenStorageInterface
     */
    private $token;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $token)
    {
        $this->em = $em;
        $this->token = $token;
    }


    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint AlreadyOwnsTeam */

        $userId = $this->token->getToken()->getUser()->getId();

        $team = $this->em->getRepository(TeamMembers::class)->findOneBy([
            'userId' => $userId
        ]);

        if($team)
        {
            $constraint->message = "You already own a team or you are part of one";
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
