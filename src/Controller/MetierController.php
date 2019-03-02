<?php

namespace App\Controller;

use App\Entity\Metier;
use App\Form\MetierType;
use App\Repository\MetierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/metier")
 */
class MetierController extends AbstractController
{
    /**
     * @Route("/", name="metier_index", methods={"GET"})
     */
    public function index(MetierRepository $metierRepository): Response
    {
        return $this->render('metier/index.html.twig', [
            'metiers' => $metierRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="metier_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $metier = new Metier();
        $form = $this->createForm(MetierType::class, $metier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($metier);
            $entityManager->flush();

            return $this->redirectToRoute('metier_index');
        }

        return $this->render('metier/new.html.twig', [
            'metier' => $metier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="metier_show", methods={"GET"})
     */
    public function show(Metier $metier): Response
    {
        return $this->render('metier/show.html.twig', [
            'metier' => $metier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="metier_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Metier $metier): Response
    {
        $form = $this->createForm(MetierType::class, $metier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('metier_index', [
                'id' => $metier->getId(),
            ]);
        }

        return $this->render('metier/edit.html.twig', [
            'metier' => $metier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="metier_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Metier $metier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$metier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($metier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('metier_index');
    }
}
