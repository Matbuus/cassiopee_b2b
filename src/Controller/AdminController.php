<?php

namespace App\Controller;

use App\Entity\TypeEvenement;
use App\Form\TypeEvenementType;
use App\Repository\MetierRepository;
use App\Repository\TypeEvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Localisation;
use App\Form\LocalisationType;
use App\Repository\LocalisationRepository;
use App\Entity\Metier;
use App\Form\MetierType;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/type_event", name="admin_type_event", methods={"GET"})
     */
    public function indexTypeEvenement(TypeEvenementRepository $typeEvenementRepository): Response
    {
        return $this->render('type_evenement/index.html.twig', [
            'type_evenements' => $typeEvenementRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/type_event/new", name="admin_type_event_new", methods={"GET","POST"})
     */
    public function newTypeEvenement(Request $request): Response
    {
        $typeEvenement = new TypeEvenement();
        $form = $this->createForm(TypeEvenementType::class, $typeEvenement);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeEvenement);
            $entityManager->flush();
            
            return $this->redirectToRoute('admin_type_event');
        }
        
        return $this->render('type_evenement/new.html.twig', [
            'type_evenement' => $typeEvenement,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/type_event/{id}", name="admin_type_event_show", methods={"GET"})
     */
    public function showTypeEvenement(TypeEvenement $typeEvenement): Response
    {
        return $this->render('type_evenement/show.html.twig', [
            'type_evenement' => $typeEvenement,
        ]);
    }
    
    /**
     * @Route("/type_event/{id}/edit", name="admin_type_event_edit", methods={"GET","POST"})
     */
    public function editTypeEvenement(Request $request, TypeEvenement $typeEvenement): Response
    {
        $form = $this->createForm(TypeEvenementType::class, $typeEvenement);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('admin_type_event', [
                'id' => $typeEvenement->getId(),
            ]);
        }
        
        return $this->render('type_evenement/edit.html.twig', [
            'type_evenement' => $typeEvenement,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/type_event/{id}", name="admin_type_event_delete", methods={"DELETE"})
     */
    public function deleteTypeEvenement(Request $request, TypeEvenement $typeEvenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeEvenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeEvenement);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('admin_type_event');
    }
    
    /**
     * @Route("/metier", name="admin_metier", methods={"GET"})
     */
    public function indexMetier(MetierRepository $metierRepository): Response
    {
        return $this->render('metier/index.html.twig', [
            'metiers' => $metierRepository->findAll(),
        ]);
    }
    
    
    /**
     * @Route("/metier/new", name="admin_metier_new", methods={"GET","POST"})
     */
    public function newMetier(Request $request): Response
    {
        $metier = new Metier();
        $form = $this->createForm(MetierType::class, $metier);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($metier);
            $entityManager->flush();
            
            return $this->redirectToRoute('admin_metier');
        }
        
        return $this->render('metier/new.html.twig', [
            'metier' => $metier,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/metier/{id}", name="admin_metier_show", methods={"GET"})
     */
    public function showMetier(Metier $metier): Response
    {
        return $this->render('metier/show.html.twig', [
            'metier' => $metier,
        ]);
    }
    
    /**
     * @Route("/metier/{id}/edit", name="admin_metier_edit", methods={"GET","POST"})
     */
    public function editMetier(Request $request, Metier $metier): Response
    {
        $form = $this->createForm(MetierType::class, $metier);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('admin_metier', [
                'id' => $metier->getId(),
            ]);
        }
        
        return $this->render('metier/edit.html.twig', [
            'metier' => $metier,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/metier/{id}", name="admin_metier_delete", methods={"DELETE"})
     */
    public function deleteMetier(Request $request, Metier $metier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$metier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($metier);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('admin_metier');
    }
    
    /**
     * @Route("/localisation", name="admin_localisation", methods={"GET"})
     */
    public function index(LocalisationRepository $localisationRepository): Response
    {
        return $this->render('localisation/index.html.twig', [
            'localisations' => $localisationRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/localisation/new", name="admin_localisation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $localisation = new Localisation();
        $form = $this->createForm(LocalisationType::class, $localisation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($localisation);
            $entityManager->flush();
            
            return $this->redirectToRoute('localisation_index');
        }
        
        return $this->render('localisation/new.html.twig', [
            'localisation' => $localisation,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/localisation/{id}", name="admin_localisation_show", methods={"GET"})
     */
    public function show(Localisation $localisation): Response
    {
        return $this->render('localisation/show.html.twig', [
            'localisation' => $localisation,
        ]);
    }
    
    /**
     * @Route("/localisation/{id}/edit", name="admin_localisation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Localisation $localisation): Response
    {
        $form = $this->createForm(LocalisationType::class, $localisation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('localisation_index', [
                'id' => $localisation->getId(),
            ]);
        }
        
        return $this->render('localisation/edit.html.twig', [
            'localisation' => $localisation,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/localisation/{id}", name="admin_localisation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Localisation $localisation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$localisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($localisation);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('admin_localisation');
    }
}
