<?php

namespace App\Controller;

use App\Entity\Request;
use App\Form\NewRequestType;
use App\Security\Voter\StatusCheckVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
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

    /**
     * @Route("/requests/history", name="request_history")
     */
    public function showRequestHistory()
    {

        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository(Request::class)->findBy([
            'user_id' => $this->getUser()->getId()
        ]);

        return $this->render("pages/dashboard/history.twig", [
            'requests' => $data
        ]);
    }

    /**
     * @Route("/requests/create_request", name="create_request", methods={"POST"})
     * @param SymfonyRequest $request
     * @return RedirectResponse
     */
    public function createNewRequest(SymfonyRequest $request)
    {

        $domain = new Request();

        $form = $this->createForm(NewRequestType::class, $domain);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $data->setUserId($this->getUser()->getId());
            $data->setTeamId(1); // TODO: Get user real team
            $data->setCreatedOn(new \DateTime());
            $data->setUpdatedBy($this->getUser()->getId());
            $em->persist($data);
            $em->flush();

            return $this->redirectToRoute('requests', [
                'message' => "You have successfully sent a request.",
                'action' => "show_history"
            ]);
        }

        return $this->redirectToRoute('requests', [
            'message' => "There was a problem with your request. Please try again.",
        ]);
    }
}
