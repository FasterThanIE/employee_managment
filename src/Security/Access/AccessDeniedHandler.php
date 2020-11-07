<?php

namespace App\Security\Access;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{

    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $response = $this->security->getUser() instanceof User ?
            new RedirectResponse("/no_team") :
            new RedirectResponse("/login");

        return new Response($response);
    }
}