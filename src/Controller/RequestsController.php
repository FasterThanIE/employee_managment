<?php

namespace App\Controller;

use App\Entity\Request;
use App\Form\NewRequestType;
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
     */
    public function showNewRequest()
    {
        $domain = new Request();
        $domain->setCreatedOn(new \DateTime());
        $form = $this->createForm(NewRequestType::class, $domain);

        return $this->render("partials/forms/new_request.twig", [
            'form' => $form->createView()
        ]);
    }
}
