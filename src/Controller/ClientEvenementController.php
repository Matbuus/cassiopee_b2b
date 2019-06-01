<?php
namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\TypeEvenement;
use App\Form\EvenementType;
use App\Form\TypeEvenementType;
use App\Form\TypePrestation1Type;
use App\Repository\EvenementRepository;
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Repository\ClientRepository;
use App\Entity\Prestation;
use App\Entity\Etat;
use App\Entity\Client;

/**
 *
 * @Route("/client")
 */
class ClientEvenementController extends AbstractController
{

    /**
     *
     * @Route("/{id}/event", name="client_evenement_index", methods={"GET"})
     */
    public function index(EvenementRepository $evenementRepository, ClientRepository $clientRepository, Client $client): Response
    {
        // return $this->render('evenement/index_react.html.twig', [
        // 'idClient' => $client->getId(),
        // 'evenements' => $evenementRepository->findBy([
        // 'client' => $client
        // ])
        // ]);
        $response = new Response();
        $response->setContent(json_encode([
            'clientId' => $client->getId(),
            'evenements' => $evenementRepository->findBy([
                'client' => $client
            ])
        
        ]));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     *
     * @Route("/{id}/event/new", name="client_evenement_new", methods={"GET","POST"})
     */
    public function new(Request $request, Client $client): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $client->addEvenement($evenement);
            $evenement->setClient($client);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->persist($client);
            $entityManager->flush();
            
            return $this->forward('App\Controller\ClientEvenementController::index', [
                'id' => $client->getId()
            ]);
        }
        
        return $this->render('evenement/new.html.twig', [
            'idClient' => $client->getId(),
            'evenement' => $evenement,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}/event/newEvent", name="client_evenement_newR", methods={"POST"})
     */
    public function newReact(Request $request, Client $client): Response
    {
        $evenement = new Evenement();
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $evenement->setAddress($request->get("address"));
        $evenement->setTitre($request->get("titre"));
        $evenement->setCity($request->get("city"));
        $evenement->setPostal($request->get("postal"));
        $evenement->setClient($client);
        $date = new \DateTime();
        $date->setDate($request->get("year"), $request->get("month"), $request->get("date"));
        $date->setTime($request->get("hours"), $request->get("minutes"));
        $evenement->setDate($date);
        $em = $this->getDoctrine()->getManager();
        $typeEvent = $em->getRepository(TypeEvenement::class)->findOneBy([
            'nom' => $request->get("nomType")
        ]);
        
//         if ($typeEvent == null) {
//             $response = new Response();
//             $response->headers->set('Content-Type', 'application/json');
//             $response->setStatusCode(404,"error");
//             // Allow all websites
//             $response->headers->set('Access-Control-Allow-Origin', '*');
//             return $response;
//         }
        
        $evenement->setTypeEvenement($typeEvent);
        $evenement->setLat($request->get("lat"));
        $evenement->setLng($request->get("lng"));
        $evenement->setEtatEvenement($em->getRepository(Etat::class)
            ->find(7));
        $localisation = new Localisation();
        $localisation->setLatitude($evenement->getLat());
        $localisation->setLongitude($evenement->getLng());
        $em->persist($localisation);
        
        $evenement->setLocalisation($localisation);
        $client->addEvenement($evenement);
        $em->persist($evenement);
        $em->persist($client);
        $em->flush();
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        $response->setContent(json_encode([
            'evenement' => $evenement,
        ]));
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     *
     * @Route("/{id}/event/{id_event}", name="client_evenement_show", methods={"GET"})
     * @Entity("evenement",expr="repository.find(id_event)")
     */
    public function show(Client $client, Evenement $evenement): Response
    {
        
        // dump($client);
        // return $this->render('evenement/show.html.twig', [
        // 'evenement' => $evenement,
        // 'idClient' => $client->getId()
        // ]);
        $response = new Response();
        $response->setContent(json_encode([
            'evenement' => $evenement,
            'idClient' => $client->getId(),
            'role' => 'partenaire'
        
        ]));
        $response->headers->set('Content-Type', 'application/json');
        
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     *
     * @Route("/{id}/event/{id_event}/edit", name="client_evenement_edit", methods={"GET","POST"})
     * @Entity("evenement",expr="repository.find(id_event)")
     */
    public function edit(Request $request, Client $client, Evenement $evenement): Response
    {
        dump($client);
        dump($evenement);
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();
            
            return $this->redirectToRoute('client_evenement_index', [
                'id' => $client->getId()
            ]);
        }
        
        return $this->render('evenement/edit.html.twig', [
            'idClient' => $client->getId(),
            'evenement' => $evenement,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="client_evenement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
//         if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
//         }
        
            
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            // Allow all websites
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
//         return $this->redirectToRoute('evenement_index');
    }

    /**
     *
     * @Route("/{id}/event/{id_event}/liste", name="client_evenement_prestations", methods={"GET"})
     * @Entity("evenement",expr="repository.find(id_event)")
     */
    public function afficherListePrestations(Client $client, Evenement $evenement): Response
    {
        dump($client);
        $em = $this->getDoctrine()->getManager();
        $etatProposer = $em->getRepository(Etat::class)->find(11);
        $etatAccepter = $em->getRepository(Etat::class)->find(12);
        $etatRefuser = $em->getRepository(Etat::class)->find(13);
        $listePrestations = $evenement->getPrestations();
        
        $listeProposer = $em->getRepository(Prestation::class)->findBy(array(
            "evenement" => $evenement,
            "etatPrestation" => $etatProposer
        ));
        $listeAccepter = $em->getRepository(Prestation::class)->findBy(array(
            "evenement" => $evenement,
            "etatPrestation" => $etatAccepter
        ));
        $listeRefuser = $em->getRepository(Prestation::class)->findBy(array(
            "evenement" => $evenement,
            "etatPrestation" => $etatRefuser
        ));
        
        return $this->render('evenement/listePrestations.html.twig', [
            'evenement' => $evenement,
            'idClient' => $client->getId(),
            'listePrestation' => $listePrestations,
            'listeProposer' => $listeProposer,
            'listeAccepter' => $listeAccepter,
            'listeRefuser' => $listeRefuser
        ]);
    }

    /**
     *
     * @Route("/{id}/event/{id_event}/prestation/{id_prest}", name="event_description_prestation", methods={"GET"})
     * @Entity("evenement",expr="repository.find(id_event)")
     * @Entity("prestation",expr="repository.find(id_prest)")
     */
    public function afficherDescription(Client $client, Evenement $evenement, Prestation $prestation): Response
    {
        return $this->render('prestation/show_prestation_client.html.twig', [
            'evenement' => $evenement,
            'idClient' => $client->getId(),
            'prestation' => $prestation
        ]);
    }

    /**
     *
     * @Route("/{id}/event/{id_event}/liste/{id_prest}/{action}", name="changer_etat_prestation", methods={"GET"})
     * @Entity("evenement",expr="repository.find(id_event)")
     * @Entity("prestation",expr="repository.find(id_prest)")
     */
    public function changeEtatPrestation(Client $client, Evenement $evenement, Prestation $prestation, String $action)
    {
        $em = $this->getDoctrine()->getManager();
        $etatAccepter = $em->getRepository(Etat::class)->find(12);
        $etatProposer = $em->getRepository(Etat::class)->find(11);
        $etatRefuser = $em->getRepository(Etat::class)->find(13);
        if ($action == "confirmer") {
            $prestation->setEtatPrestation($etatAccepter);
        }
        if ($action == "refuser") {
            $prestation->setEtatPrestation($etatRefuser);
        }
        $em->persist($prestation);
        $em->flush();
        
        $listeAccepter = $em->getRepository(Prestation::class)->findBy([
            "etatPrestation" => $etatAccepter
        ]);
        $listeRefuser = $em->getRepository(Prestation::class)->findBy([
            "etatPrestation" => $etatRefuser
        ]);
        $listeProposer = $em->getRepository(Prestation::class)->findBy([
            "etatPrestation" => $etatProposer
        ]);
        return $this->redirectToRoute('client_evenement_prestations', [
            'id_event' => $evenement->getId(),
            'id' => $client->getId(),
            'listeProposer' => $listeProposer,
            'listeAccepter' => $listeAccepter,
            'listeRefuser' => $listeRefuser
        ]);
    }
}