<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestsController extends AbstractController
{
    /**
     * @Route("/requests", name="requests")
     * @return Response
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render("pages/dashboard/requests.twig");
    }

    /**
     * @Route("/requests/new_request", name="new_request")
     * @return JsonResponse
     */
    public function showNewRequest(): JsonResponse
    {

        return $this->json(['success' => true]);
    }
}
