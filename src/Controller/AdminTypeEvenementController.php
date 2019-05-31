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
 *
 * @Route("/admin")
 */
class AdminTypeEvenementController extends AbstractController
{

    /**
     *
     * @Route("/type_event", name="admin_type_event", methods={"GET"})
     */
    public function indexTypeEvenement(TypeEvenementRepository $typeEvenementRepository): Response
    {
        // return $this->render('type_evenement/index.html.twig', [
        // 'type_evenements' => $typeEvenementRepository->findAll(),
        // ]);
        $response = new Response();
        $response->setContent(json_encode([
            'type_evenements' => $typeEvenementRepository->findAll()
        ]));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     *
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
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/type_event/newType", name="admin_type_event_newT", methods={"POST"})
     */
    public function newTypeEvenementReact(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $typeEvent = new TypeEvenement();
        $typeEvent->setNom($request->get('nom'));
        $this->getDoctrine()
            ->getManager()
            ->persist($typeEvent);
        $this->getDoctrine()
            ->getManager()
            ->flush();
        
        $response = new Response();
        $response->setContent(json_encode([
            'type_evenement' => $typeEvent
        ]));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     *
     * @Route("/type_event/{id}", name="admin_type_event_show", methods={"GET"})
     */
    public function showTypeEvenement(TypeEvenement $typeEvenement): Response
    {
        dump($typeEvenement);
        return $this->render('type_evenement/show.html.twig', [
            'type_evenement' => $typeEvenement
        ]);
    }

    /**
     *
     * @Route("/type_event/{id}/edit", name="admin_type_event_edit", methods={"GET","POST"})
     */
    public function editTypeEvenement(Request $request, TypeEvenement $typeEvenement): Response
    {
        $form = $this->createForm(TypeEvenementType::class, $typeEvenement);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();
            
            return $this->redirectToRoute('admin_type_event', [
                'id' => $typeEvenement->getId()
            ]);
        }
        
        return $this->render('type_evenement/edit.html.twig', [
            'type_evenement' => $typeEvenement,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/type_event/{id}", name="admin_type_event_delete", methods={"DELETE"})
     */
    public function deleteTypeEvenement(Request $request, TypeEvenement $typeEvenement): Response
    {
//         $data = json_decode($request->request, true);
        
        
//         $token = $request->request->get("data")->get("token");
        // if ($this->isCsrfTokenValid('delete'.$typeEvenement->getId(), $request->request->get('_token'))) {
//         if ($token == "12345") {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeEvenement);
            $entityManager->flush();
           
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
        
        // return $this->redirectToRoute('admin_type_event');
    }
}