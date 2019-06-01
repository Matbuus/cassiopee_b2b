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
use App\Entity\TypePrestation;
use App\Entity\Etat;
use App\Entity\Partenaire;

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
            foreach ($partenaire->getMetier()->getTypesPrestations() as $typePrestation){
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
            'form' => $form->createView(),
        ]);    
    }
    /**
     * @Route("/{id}/events", name="evenement_index_partenaire", methods={"GET"})
     */
    public function eventsForPartenaire(Partenaire $partenaire)
    {
        $typesPrestations = $partenaire->getTypePrestations();
        $events = array();
        foreach ($typesPrestations as $typePrestation){
            $typeEvent = $typePrestation->getTypeEvent();
            $to_add = $this->getDoctrine()->getManager()->getRepository(Evenement::class)->findBy(['typeEvenement' => $typeEvent]) ;
            foreach($to_add as $event)
                if(!in_array($event, $events))
                    $events[] = $event;
        }
        dump($events);
        $i = 0;
        $distevent = array();
        foreach ($events as $evt){
            $distance = 3956 * 2 * asin(sqrt( pow(sin(($partenaire->getLat() - $evt->getLat()) *  pi()/180 / 2) , 2) + cos($partenaire->getLat() * pi()/180) * cos($evt->getLat() * pi()/180) * pow(sin($partenaire->getLng() - $evt->getLng()) * pi()/180 / 2 ,2) ));
            $distevent[$i] = $distance;
            $i++;
        }
        $distanceEvenement=$distevent;
        $sortedEventsIndex = array();
        dump(count($distevent));
        $maxdist=max($distevent);
        for($i=1;$i<=count($distevent);$i++)
        {
            $mindist= min($distevent);
            $sortedEventsIndex[$i-1]=array_keys($distevent, $mindist)[0];
            $distevent[array_keys($distevent, $mindist)[0]]= $maxdist+1;
        }
        dump($sortedEventsIndex);
        return $this->render('evenement/liste_events_partenaire.html.twig', [
            'id' => $partenaire->getId(),
            'evenements' => $events,
            'sortedEventsIndex'=> $sortedEventsIndex,
            'distanceEvenement'=>$distanceEvenement,
        ]);
    }
    
    /**
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
            //$etat = $entityManager->getRepository(Etat::class)->find(3);
            //$prestation->setEtatPrestation($etat);
            $entityManager->persist($partenaire);
            $entityManager->persist($evenement);
            //$entityManager->persist($etat);
            $entityManager->persist($prestation);
            $entityManager->flush();
            
            return $this->redirectToRoute('prestation_index');
        }
        
        return $this->render('prestation/new.html.twig', [
            'prestation' => $prestation,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("{id}/type_prestation/{id_tp}", name="partenaire_type_prestation_delete", methods={"DELETE"})
     * @Entity("typePrestation",expr="repository.find(id_tp)")
     */
    public function deleteTypePrestation(Request $request, Partenaire $partenaire, TypePrestation $typePrestation): Response
    {
            dump($partenaire);
            dump($typePrestation);
        if ($this->isCsrfTokenValid('delete'.$typePrestation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
           // $entityManager->remove($typePrestation);
            $partenaire->removeTypePrestation($typePrestation);
            $entityManager->persist($partenaire);
            //$entityManager->persist($object)
            $entityManager->flush();
        }
        
        $response = $this->forward('App\Controller\PartenaireController::show', ['id' =>$partenaire->getId(),]);
        
        return $response;
    }
    
}
