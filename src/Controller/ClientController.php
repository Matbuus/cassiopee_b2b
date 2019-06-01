<?php
namespace App\Controller;

use App\Form\ClientType;
use App\Form\ClientType1Type;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use Symfony\Component\Validator\Constraints\Email;

/**
 *
 * @Route("/cclient")
 */
class ClientController extends AbstractController
{

    /**
     *
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        // return $this->render('client/index.html.twig', [
        // 'clients' => $clientRepository->findAll()
        // ]);
        $response = new Response();
        $response->setContent(json_encode([
            'clients' => $clientRepository->findAll()
        ]));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     *
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType1Type::class, $client);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
            
            return $this->redirectToRoute('client_index');
        }
        
        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/newReact", name="client_newR", methods={"POST"})
     */
    public function newClient(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $em = $this->getDoctrine()->getManager();
        $client = new Client();
        
        $client->setEmail($request->get("email"));
        $client->setPrenom($request->get("prenom"));
        $client->setNom($request->get("nom"));
        $client->setAddress($request->get("address"));
        $client->setCity($request->get("city"));
        $client->setLat($request->get("lat"));
        $client->setLng($request->get("lng"));
        $client->setPassword($request->get("password"));
        $client->setPostal($request->get("postal"));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     *
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        // return $this->render('client/show.html.twig', [
        // 'client' => $client,
        // ]);
        $response = new Response();
        $response->setContent(json_encode([
            'client' => $client
        ]));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     *
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();
            
            return $this->redirectToRoute('client_index', [
                'id' => $client->getId()
            ]);
        }
        
        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="client_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Client $client): Response
    {
        // if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($client);
        $entityManager->flush();
        // }
        $response = new Response();
        // $response->setContent(json_encode([
        // 'clients' => $clientRepository->findAll()
        // ]));
        $response->headers->set('Content-Type', 'application/json');
        
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        // return $this->redirectToRoute('client_index');
    }
}
