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
class AdminMetierController extends AbstractController
{
    
    /**
     * @Route("/metier", name="admin_metier", methods={"GET"})
     */
    public function indexMetier(MetierRepository $metierRepository): Response
    {
//         return $this->render('metier/index.html.twig', [
//             'metiers' => $metierRepository->findAll(),
//         ]);
        $response = new Response();
        $response->setContent(json_encode([
            'metiers' => $metierRepository->findAll(),
        ]));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
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
     * @Route("/metier/newMetier", name="admin_metier_newR", methods={"POST"})
     */
    public function newMetierReac(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $metier = new Metier();
        $metier->setTitre($request->get('titre'));
        $this->getDoctrine()->getManager()->persist($metier);
        $this->getDoctrine()->getManager()->flush();
        
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        
    }
   
    
    /**
     * @Route("/metier/{id}", name="admin_metier_show", methods={"GET"})
     */
    public function showMetier(Metier $metier): Response
    {
        $typesPrestations = $metier->getTypesPrestations();
//         dump($typesPrestations);
//         return $this->render('metier/show.html.twig', [
//             'metier' => $metier,
//             'typesPrestations' => $typesPrestations,
//         ]);
        
        $response = new Response();
        $typesPrestations = $typesPrestations->toArray();
        $response->setContent(json_encode([
            'metier' => $metier,
            'typesPrestations' => $typesPrestations
        ]));
    
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        
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
//         if ($this->isCsrfTokenValid('delete'.$metier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($metier);
            $entityManager->flush();
//         } 
            // $response->setContent(json_encode([
            // 'clients' => $clientRepository->findAll()
            // ]));
            //         }
            
            
            //          $response = new Response();
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            //         $response->headers->set('token' , $token);
            // Allow all websites
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
//         return $this->redirectToRoute('admin_metier');
    }
    
}