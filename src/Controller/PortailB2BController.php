<?php

namespace App\Controller;

use App\Entity\PortailB2B;
use App\Form\PortailB2BType;
use App\Repository\PortailB2BRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portail/b2/b")
 */
class PortailB2BController extends AbstractController
{
    /**
     * @Route("/", name="portail_b2_b_index", methods={"GET"})
     */
    public function index(PortailB2BRepository $portailB2BRepository): Response
    {
        return $this->render('portail_b2_b/index.html.twig', [
            'portail_b2_bs' => $portailB2BRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="portail_b2_b_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $portailB2B = new PortailB2B();
        $form = $this->createForm(PortailB2BType::class, $portailB2B);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($portailB2B);
            $entityManager->flush();

            return $this->redirectToRoute('portail_b2_b_index');
        }

        return $this->render('portail_b2_b/new.html.twig', [
            'portail_b2_b' => $portailB2B,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="portail_b2_b_show", methods={"GET"})
     */
    public function show(PortailB2B $portailB2B): Response
    {
        return $this->render('portail_b2_b/show.html.twig', [
            'portail_b2_b' => $portailB2B,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="portail_b2_b_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PortailB2B $portailB2B): Response
    {
        $form = $this->createForm(PortailB2BType::class, $portailB2B);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('portail_b2_b_index', [
                'id' => $portailB2B->getId(),
            ]);
        }

        return $this->render('portail_b2_b/edit.html.twig', [
            'portail_b2_b' => $portailB2B,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="portail_b2_b_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PortailB2B $portailB2B): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portailB2B->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($portailB2B);
            $entityManager->flush();
        }

        return $this->redirectToRoute('portail_b2_b_index');
    }
}
