<?php

namespace App\Controller;

use App\Entity\TypeEvenement;
use App\Form\TypeEvenementType;
use App\Repository\TypeEvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/evenement")
 */
class TypeEvenementController extends AbstractController
{
    /**
     * @Route("/", name="type_evenement_index", methods={"GET"})
     */
    public function index(TypeEvenementRepository $typeEvenementRepository): Response
    {
        return $this->render('type_evenement/index.html.twig', [
            'type_evenements' => $typeEvenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_evenement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeEvenement = new TypeEvenement();
        $form = $this->createForm(TypeEvenementType::class, $typeEvenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeEvenement);
            $entityManager->flush();

            return $this->redirectToRoute('type_evenement_index');
        }

        return $this->render('type_evenement/new.html.twig', [
            'type_evenement' => $typeEvenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_evenement_show", methods={"GET"})
     */
    public function show(TypeEvenement $typeEvenement): Response
    {
        return $this->render('type_evenement/show.html.twig', [
            'type_evenement' => $typeEvenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_evenement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeEvenement $typeEvenement): Response
    {
        $form = $this->createForm(TypeEvenementType::class, $typeEvenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_evenement_index', [
                'id' => $typeEvenement->getId(),
            ]);
        }

        return $this->render('type_evenement/edit.html.twig', [
            'type_evenement' => $typeEvenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_evenement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeEvenement $typeEvenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeEvenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeEvenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_evenement_index');
    }
}
