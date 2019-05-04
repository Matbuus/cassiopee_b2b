<?php
namespace App\Controller;

use App\Entity\Partenaire;
use App\Form\PartenaireType;
use App\Form\TypePrestation1Type;
use App\Form\TypePrestation2Type;
use App\Repository\PartenaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TypePrestation;

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
            foreach ($partenaire->getMetier()->getTypesPrestations() as $typePrestation)
                $partenaire->addTypePrestation($typePrestation);
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
        dump($partenaire->getTypePrestations()->get(0)->getTypeEvent());
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
                ->add('message', 'type de prestation bien ajoutée au métier');
            
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
}
