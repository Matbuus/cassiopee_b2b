<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Repository\EtatRepository;
use App\Form\EtatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etat")
 */
class EtatController extends AbstractController
{
    /**
     * @Route("/", name="etat_index", methods={"GET"})
     */
    public function index(EtatRepository $etatRepository): Response
    {
        return $this->render('etat/index.html.twig', [
            'etats' => $etatRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="etat_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $etat = new Etat();
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etat);
            $entityManager->flush();

            return $this->redirectToRoute('etat_index');
        }

        return $this->render('etat/new.html.twig', [
            'etat' => $etat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etat_show", methods={"GET"})
     */
    public function show(Etat $etat): Response
    {
        return $this->render('etat/show.html.twig', [
            'etat' => $etat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Etat $etat): Response
    {
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etat_index', [
                'id' => $etat->getId(),
            ]);
        }

        return $this->render('etat/edit.html.twig', [
            'etat' => $etat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etat_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Etat $etat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etat_index');
    }
}
