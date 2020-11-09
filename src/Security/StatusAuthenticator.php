<?php

namespace App\Security;


use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class StatusAuthenticator implements AccessDecisionManagerInterface
{
    /**
     * @param TokenInterface $token
     * @param array $attributes
     * @param null $object
     * @return bool|void
     */
    public function decide(TokenInterface $token, array $attributes, $object = null)
    {
        if ($token->getUser()->getStatus() == User::USER_STATUS_PENDING) {
            // Needs to be redirected to /pending
            return true;
        }

        return true;
    }
}