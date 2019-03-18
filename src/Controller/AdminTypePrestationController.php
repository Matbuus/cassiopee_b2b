<?php

namespace App\Controller;

use App\Entity\TypeEvenement;
use App\Form\TypeEvenementType;
use App\Form\TypePrestation1Type;
use App\Repository\MetierRepository;
use App\Repository\TypeEvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Localisation;
use App\Form\LocalisationType;
use App\Repository\LocalisationRepository;
use App\Entity\Metier;
use App\Form\MetierType;
use App\Entity\TypePrestation;
use App\Form\TypePrestationType;
use App\Repository\TypePrestationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



/**
 * @Route("/admin")
 */
class AdminTypePrestationController extends AbstractController
{
    
    
    /**
     * @Route("/type_prestation", name="admin_type_prestation", methods={"GET"})
     */
    public function indexTypePrestation(TypePrestationRepository $typePrestationRepository): Response
    {
        return $this->render('type_prestation/index.html.twig', [
            'type_prestations' => $typePrestationRepository->findAll(),
        ]);
    }
    
    /**
     *
     * @Route("/metier/{id}/type_prestation/add", name="admin_type_prestation_add", methods="GET|POST")
     * @param
     */
    public function addTypePrestation(Request $request, Metier $metier): Response
    {
        $typePrestation = new TypePrestation();
        $form = $this->createForm(TypePrestation1Type::class, $typePrestation);
        $form->handleRequest($request);
        dump($metier);
        if ($form->isSubmitted() && $form->isValid()) {
            $typePrestation->setMetier($metier);
            $metier->addTypesPrestation($typePrestation);
            $em = $this->getDoctrine()->getManager();
            $em->persist($typePrestation);
            $em->persist($metier);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('message', 'type de prestation bien ajoutée au métier');
            
            $response = $this->forward('App\Controller\AdminMetierController::showMetier', ['id' => $metier->getId(),]);
            return $response;
        }
        

        
        return $this->render('type_prestation/new.html.twig', [
            'metier' => $metier,
            'typePrestation' => $typePrestation,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/type_prestation/{id}", name="admin_type_prestation_show", methods={"GET"})
     */
    public function showTypePrestation(TypePrestation $typePrestation): Response
    {
        return $this->render('type_prestation/show.html.twig', [
            'type_prestation' => $typePrestation,
        ]);
    }
    
    /**
     * @Route("/type_prestation/{id}/edit", name="admin_type_prestation_edit", methods={"GET","POST"})
     */
    public function editTypePrestation(Request $request, TypePrestation $typePrestation): Response
    {
        $form = $this->createForm(TypePrestationType::class, $typePrestation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('admin_type_prestation', [
                'id' => $typePrestation->getId(),
            ]);
        }
        
        return $this->render('type_prestation/edit.html.twig', [
            'type_prestation' => $typePrestation,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/type_prestation/{id}", name="admin_type_prestation_delete", methods={"DELETE"})
     */
    public function deleteTypePrestation(Request $request, TypePrestation $typePrestation): Response
    {
        $id = $typePrestation->getMetier()->getId();
        if ($this->isCsrfTokenValid('delete'.$typePrestation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typePrestation);
            $entityManager->flush();
        }
        
        $response = $this->forward('App\Controller\AdminMetierController::showMetier', ['id' => $id,]);
        
        return $response;
    }
   
    
}