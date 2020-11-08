<?php

namespace App\Controller;

use App\Entity\Request;
use App\Form\NewRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestsController extends AbstractController
{
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
        $domain->setCreatedOn(new \DateTime());
        $form = $this->createForm(NewRequestType::class, $domain);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $data->setUserId($this->getUser()->getId());
            $data->setCreatedOn(new \DateTime());
            $data->setUpdatedBy($this->getUser()->getId());
            $em->persist($data);
            $em->flush();

            return $this->render("pages/dashboard/requests.twig",[
                'requests' => $requests,
                'form' => $form->createView(),
                'success' => true,
            ]);
        }

        return $this->render("pages/dashboard/requests.twig",[
            'requests' => $requests,
            'form' => $form->createView(),
            'success' => false,
        ]);
    }
}
