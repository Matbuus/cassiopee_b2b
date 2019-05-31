<?php
namespace App\Controller;

use App\Entity\Partenaire;
use App\Entity\TypeEvenement;
use App\Form\TypeEvenementType;
use App\Form\TypePrestation1Type;
use App\Form\TypePrestation2Type;
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
use App\Repository\PartenaireRepository;

/**
 *
 * @Route("/admin")
 */
class AdminTypePrestationController extends AbstractController
{

    /**
     *
     * @Route("/type_prestation", name="admin_type_prestation", methods={"GET"})
     */
    public function indexTypePrestation(TypePrestationRepository $typePrestationRepository): Response
    {
        // return $this->render('type_prestation/index.html.twig', [
        // 'type_prestations' => $typePrestationRepository->findAll(),
        // ]);
        $response = new Response();
        $response->setContent(json_encode([
            'type_prestations' => $typePrestationRepository->findAll()
        ]));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
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
            $typePrestation->getTypeEvent()->addTypePrestation($typePrestation);
            $metier->addTypesPrestation($typePrestation);
            $em = $this->getDoctrine()->getManager();
            $partenaires = $em->getRepository(Partenaire::class)->findBy([
                "metier" => $metier
            ]);
            foreach ($partenaires as $partenaire) {
                $partenaire->addTypePrestation($typePrestation);
                $em->persist($partenaire);
                $typePrestation->addPartenaire($partenaire);
            }
            
            $em->persist($typePrestation);
            $em->persist($metier);
            $em->persist($typePrestation->getTypeEvent());
            $em->flush();
            
            $this->get('session')
                ->getFlashBag()
                ->add('message', 'type de prestation bien ajoutée au métier');
            
            $response = $this->forward('App\Controller\AdminMetierController::showMetier', [
                'id' => $metier->getId()
            ]);
            return $response;
        }
        
        return $this->render('type_prestation/new.html.twig', [
            'metier' => $metier,
            'typePrestation' => $typePrestation,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/metier/{id}/type_prestation/addT", name="admin_type_prestation_addT", methods={"POST"})
     * @param
     */
    public function addTypePrestationR(Request $request, Metier $metier): Response
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $em = $this->getDoctrine()->getManager();
        
        $typePrestation = new TypePrestation();
        $typePrestation->setMetier($metier);
        $typePrestation->setDescription($request->get("description"));
        $typePrestation->setNomType($request->get("nomType"));
        $typePrestation->setTarifPublic($request->get("tarifPublic"));
        
        
        $typeEvent = $em->getRepository(TypeEvenement::class)->findOneBy([
            'nom' => $request->get("titre")
        ]);
        
        
        if($typeEvent == null){
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('titre', $request->get($titre));
            // Allow all websites
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
            
        }
        $typePrestation->setTypeEvent($typeEvent);
        
        $typePrestation->getTypeEvent()->addTypePrestation($typePrestation);
        $metier->addTypesPrestation($typePrestation);
        
        $partenaires = $em->getRepository(Partenaire::class)->findBy([
            "metier" => $metier
        ]);
        foreach ($partenaires as $partenaire) {
            $partenaire->addTypePrestation($typePrestation);
            $em->persist($partenaire);
            $typePrestation->addPartenaire($partenaire);
        }
        
        $em->persist($typePrestation);
        $em->persist($metier);
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
     * @Route("/type_prestation/{id}", name="admin_type_prestation_show", methods={"GET"})
     */
    public function showTypePrestation(TypePrestation $typePrestation): Response
    {
        return $this->render('type_prestation/show.html.twig', [
            'type_prestation' => $typePrestation
        ]);
    }

    /**
     *
     * @Route("/type_prestation/{id}/edit", name="admin_type_prestation_edit", methods={"GET","POST"})
     */
    public function editTypePrestation(Request $request, TypePrestation $typePrestation): Response
    {
        $form = $this->createForm(TypePrestation2Type::class, $typePrestation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();
            
            return $this->redirectToRoute('admin_type_prestation', [
                'id' => $typePrestation->getId()
            ]);
        }
        
        return $this->render('type_prestation/edit.html.twig', [
            'type_prestation' => $typePrestation,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/type_prestation/{id}", name="admin_type_prestation_delete", methods={"DELETE"})
     */
    public function deleteTypePrestation(Request $request, TypePrestation $typePrestation): Response
    {
        $id = $typePrestation->getMetier()->getId();
        if ($this->isCsrfTokenValid('delete' . $typePrestation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typePrestation);
            $entityManager->flush();
        }
        
        $response = $this->forward('App\Controller\AdminMetierController::showMetier', [
            'id' => $id
        ]);
        
        return $response;
    }
}