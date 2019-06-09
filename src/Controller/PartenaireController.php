<?php
namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Prestation;
use App\Form\EvenementType;
use App\Form\PrestationType;
use App\Form\PartenaireType;
use App\Form\TypePrestation1Type;
use App\Form\TypePrestation2Type;
use App\Repository\PartenaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Entity\TypeEvenement;
use App\Entity\TypePrestation;
use App\Entity\Etat;
use App\Entity\Partenaire;
use App\Entity\Metier;

/**
 *
 * @Route("/partenaire")
 */
class PartenaireController extends AbstractController
{

    /**
     *
     * @Route("/", name="partenaire_index", methods={"GET"})
     */
    public function index(PartenaireRepository $partenaireRepository): Response
    {
        return $this->render('partenaire/index.html.twig', [
            'partenaires' => $partenaireRepository->findAll()
        ]);
    }

    /**
     *
     * @Route("/new", name="partenaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($partenaire->getMetier()->getTypesPrestations() as $typePrestation) {
                $partenaire->addTypePrestation($typePrestation);
                $typePrestation->addPartenaire($partenaire);
                $entityManager->persist($typePrestation);
            }
            $entityManager->persist($partenaire);
            $entityManager->flush();
            
            return $this->redirectToRoute('partenaire_index');
        }
        
        return $this->render('partenaire/new.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/newReact", name="partenaire_newR", methods={"POST"})
     */
    public function newReact(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $em = $this->getDoctrine()->getManager();
        $partenaire = new Partenaire();
        
        $partenaire->setEmail($request->get("email"));
        $partenaire->setPrenom($request->get("prenom"));
        $partenaire->setNom($request->get("nom"));
        $partenaire->setAddress($request->get("address"));
        $partenaire->setCity($request->get("city"));
        $partenaire->setLat($request->get("lat"));
        $partenaire->setLng($request->get("lng"));
        $partenaire->setPassword($request->get("password"));
        $partenaire->setPostal($request->get("postal"));
        
        $nomMetier = $request->get('metier');
        
        $entityManager = $this->getDoctrine()->getManager();
        $metier = $entityManager->getRepository(Metier::class)->findOneBy([
            'titre' => $nomMetier
        ]);
        $partenaire->setMetier($metier);
        
        foreach ($partenaire->getMetier()->getTypesPrestations() as $typePrestation) {
            $partenaire->addTypePrestation($typePrestation);
            $typePrestation->addPartenaire($partenaire);
            $entityManager->persist($typePrestation);
        }
        
        $entityManager->persist($partenaire);
        $entityManager->flush();
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     *
     * @Route("/{id}", name="partenaire_show", methods={"GET"})
     */
    public function show(Partenaire $partenaire): Response
    {
        return $this->render('partenaire/show.html.twig', [
            'partenaire' => $partenaire,
            'typePrestations' => $partenaire->getTypePrestations()
        ]);
    }

    /**
     *
     * @Route("/{id}/types_prestation", name="types_prestation_partenaire", methods={"GET"})
     */
    public function typesPrestation(Partenaire $partenaire): Response
    {
        // return $this->render('partenaire/show.html.twig', [
        // 'partenaire' => $partenaire,
        // 'typePrestations' => $partenaire->getTypePrestations()
        // ]);
        $response = new Response();
        $response->setContent(json_encode([
            'typePrestations' => $partenaire->getTypePrestations()
                ->toArray()
        ]));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     *
     * @Route("/{id}/edit", name="partenaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partenaire $partenaire): Response
    {
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();
            
            return $this->redirectToRoute('partenaire_index', [
                'id' => $partenaire->getId()
            ]);
        }
        
        return $this->render('partenaire/edit.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="partenaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Partenaire $partenaire): Response
    {
        if ($this->isCsrfTokenValid('delete' . $partenaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partenaire);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('partenaire_index');
    }

    /**
     *
     * @Route("/{id}/type_prestation/add", name="partenaire_type_prestation_add", methods="GET|POST")
     * @param
     */
    public function addTypePrestation(Request $request, Partenaire $partenaire): Response
    {
        $typePrestation = new TypePrestation();
        $form = $this->createForm(TypePrestation1Type::class, $typePrestation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $typePrestation->addPartenaire($partenaire);
            $partenaire->addTypePrestation($typePrestation);
            $em = $this->getDoctrine()->getManager();
            $em->persist($typePrestation);
            $em->persist($partenaire);
            $em->flush();
            
            $this->get('session')
                ->getFlashBag()
                ->add('message', 'type de prestation bien ajout� au m�tier');
            
            $response = $this->forward('App\Controller\PartenaireController::show', [
                'id' => $partenaire->getId()
            ]);
            return $response;
        }
        
        return $this->render('type_prestation/new.html.twig', [
            '$partenaire' => $partenaire,
            'typePrestation' => $typePrestation,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}/type_prestation/addT", name="part_type_prestation_addT", methods={"POST"})
     * @param
     */
    public function addTypePrestationR(Request $request, Partenaire $partenaire): Response
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $em = $this->getDoctrine()->getManager();
        
        $typePrestation = new TypePrestation();
        $typePrestation->setDescription($request->get("description"));
        $typePrestation->setNomType($request->get("nomType"));
        $typePrestation->setTarifPublic($request->get("tarifPublic"));
        
        $typeEvent = $em->getRepository(TypeEvenement::class)->findOneBy([
            'nom' => $request->get("titre")
        ]);
        
        $typePrestation->setTypeEvent($typeEvent);
        
        $typePrestation->getTypeEvent()->addTypePrestation($typePrestation);
        $typePrestation->addPartenaire($partenaire);
        $partenaire->addTypePrestation($typePrestation);
        
        $em->persist($typePrestation);
        $em->persist($partenaire);
        $em->persist($typePrestation->getTypeEvent());
        $em->flush();
        
        $this->get('session')
            ->getFlashBag()
            ->add('message', 'type de prestation bien ajoutée au métier');
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        
        // return $this->render('type_prestation/new.html.twig', [
        // 'metier' => $metier,
        // 'typePrestation' => $typePrestation,
        // 'form' => $form->createView()
        // ]);
    }
    
    
    
    /**
     *
     * @Route("/{id}/prestations", name="mesPrestations", methods={"GET"})
     */
    public function mesPrestations(Partenaire $partenaire): Response
    {
        
//         return $this->render('prestation/index.html.twig', [
//             'prestations' => $prestationRepository->findAll(),
//         ]);
        
        $response = new Response();
        $response->setContent(json_encode([
            'prestations' => $partenaire->getPrestationsProposees()->toArray()
        ]));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    


    /**
     *
     * @Route("/{id}/events", name="evenement_index_partenaire", methods={"GET"})
     */
    public function eventsForPartenaire(Partenaire $partenaire)
    {
        $typesPrestations = $partenaire->getTypePrestations();
        $events = array();
        foreach ($typesPrestations as $typePrestation) {
            $typeEvent = $typePrestation->getTypeEvent();
            $to_add = $this->getDoctrine()
                ->getManager()
                ->getRepository(Evenement::class)
                ->findBy([
                'typeEvenement' => $typeEvent
            ]);
            foreach ($to_add as $event)
                if (! in_array($event, $events))
                    $events[] = $event;
        }
        dump($events);
        $i = 0;
        $distevent = array();
        foreach ($events as $evt) {
            $distance = 3956 * 2 * asin(sqrt(pow(sin(($partenaire->getLat() - $evt->getLat()) * pi() / 180 / 2), 2) + cos($partenaire->getLat() * pi() / 180) * cos($evt->getLat() * pi() / 180) * pow(sin($partenaire->getLng() - $evt->getLng()) * pi() / 180 / 2, 2)));
            $distevent[$i] = $distance;
            $i ++;
        }
        $distanceEvenement = $distevent;
        $sortedEventsIndex = array();
        dump(count($distevent));
        $maxdist = max($distevent);
        for ($i = 1; $i <= count($distevent); $i ++) {
            $mindist = min($distevent);
            $sortedEventsIndex[$i - 1] = array_keys($distevent, $mindist)[0];
            $distevent[array_keys($distevent, $mindist)[0]] = $maxdist + 1;
        }
        dump($sortedEventsIndex);
        // return $this->render('evenement/liste_events_partenaire.html.twig', [
        // 'id' => $partenaire->getId(),
        // 'evenements' => $events,
        // 'sortedEventsIndex' => $sortedEventsIndex,
        // 'distanceEvenement' => $distanceEvenement
        // ]);
        
        $response = new Response();
        $response->setContent(json_encode([
            'evenements' => $events,
            'sortedEventsIndex' => $sortedEventsIndex,
            'distanceEvenement' => $distanceEvenement
        ]));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     *
     * @Route("/{id}/event/{id_event}/prestation", name="partenaire_proposer_prestation", methods={"GET","POST"})
     * @Entity("evenement",expr="repository.find(id_event)")
     */
    public function proposerPrestation(Request $request, Partenaire $partenaire, Evenement $evenement): Response
    {
        $prestation = new Prestation();
        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $prestation->setPartenaire($partenaire);
            $prestation->setEvenement($evenement);
            // $etat = $entityManager->getRepository(Etat::class)->find(3);
            // $prestation->setEtatPrestation($etat);
            $entityManager->persist($partenaire);
            $entityManager->persist($evenement);
            // $entityManager->persist($etat);
            $entityManager->persist($prestation);
            $entityManager->flush();
            
            return $this->redirectToRoute('prestation_index');
        }
        
        return $this->render('prestation/new.html.twig', [
            'prestation' => $prestation,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}/event/{id_event}/prestationR", name="partenaire_proposer_prestationR", methods={"POST"})
     * @Entity("evenement",expr="repository.find(id_event)")
     */
    public function proposerPrestationReact(Request $request, Partenaire $partenaire, Evenement $evenement): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $prestation = new Prestation();
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $dated = new \DateTime();
        $dated->setDate($request->get("yeard"), $request->get("monthd"), $request->get("dated"));
        $dated->setTime($request->get("hoursd"), $request->get("minutesd"));
        
        $datef = new \DateTime();
        $datef->setDate($request->get("yearf"), $request->get("monthf"), $request->get("datef"));
        $datef->setTime($request->get("hoursf"), $request->get("minutesf"));
        
        $etatPrestation = $entityManager->getRepository(Etat::class)->find(11);
        
       
        
        $typePrestation = $entityManager->getRepository(TypePrestation::class)->find($request->get("typeId"));
        $prestation->setDateDebut($dated);
        $prestation->setDateFin($datef);
        $prestation->setEtatPrestation($etatPrestation);
        $prestation->setTypePrestation($typePrestation);
        $prestation->setPartenaire($partenaire);
        $prestation->setEvenement($evenement);
        // $etat = $entityManager->getRepository(Etat::class)->find(3);
        // $prestation->setEtatPrestation($etat);
        $entityManager->persist($partenaire);
        $entityManager->persist($evenement);
        // $entityManager->persist($etat);
        $entityManager->persist($prestation);
        $entityManager->flush();
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent(json_encode([
            'prestation' => $prestation,
        ]));
        return $response;
    }

    /**
     *
     * @Route("{id}/type_prestation/{id_tp}", name="partenaire_type_prestation_delete", methods={"DELETE"})
     * @Entity("typePrestation",expr="repository.find(id_tp)")
     */
    public function deleteTypePrestation(Request $request, Partenaire $partenaire, TypePrestation $typePrestation): Response
    {
        dump($partenaire);
        dump($typePrestation);
        if ($this->isCsrfTokenValid('delete' . $typePrestation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->remove($typePrestation);
            $partenaire->removeTypePrestation($typePrestation);
            $entityManager->persist($partenaire);
            // $entityManager->persist($object)
            $entityManager->flush();
        }
        
        $response = $this->forward('App\Controller\PartenaireController::show', [
            'id' => $partenaire->getId()
        ]);
        
        return $response;
    }
}
