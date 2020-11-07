<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class StatusCheckVoter extends Voter
{
    const USER_PENDING = "user_pending";

    protected function supports($attribute, $subject)
    {
        if($attribute != self::USER_PENDING || $attribute == self::USER_PENDING && !$subject instanceof User)
        {
            return false;
        }
        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if(!$user instanceof User)
        {
            return false;
        }

        return $user->getStatus() != User::USER_STATUS_PENDING;
    }
}
