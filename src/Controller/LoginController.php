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
use App\Entity\Client;


class LoginController extends AbstractController
{

    /**
     *
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        $em = $this->getDoctrine()->getManager();
        $email = $request->get("email");
        $password = $request->get("password");
        
        if ($email == "admin" && $password == "admin") {
            $response = new Response();
            $response->setContent(json_encode([
                'connected' => 'true',
                'role' => "admin",
                'userId' => '0'
            ]));
            $response->headers->set('Content-Type', 'application/json');
            // Allow all websites
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        } else {
            $client = $em->getRepository(Client::class)->findOneBy([
                'email' => $email
            ]);
            if ($client != null) {
                if ($client->getPassword() == $password) {
                    $response = new Response();
                    $response->setContent(json_encode([
                        'connected' => 'true',
                        'role' => "client",
                        'userId' => $client->getId()
                    ]));
                    $response->headers->set('Content-Type', 'application/json');
                    // Allow all websites
                    $response->headers->set('Access-Control-Allow-Origin', '*');
                    return $response;
                }
                else {
                    $response = new Response();
                    $response->setStatusCode(404, 'error, password incorrect');
                    $response->headers->set('Content-Type', 'application/json');
                    // Allow all websites
                    $response->headers->set('Access-Control-Allow-Origin', '*');
                    return $response;
                }
            } else {
                $response = new Response();
                $response->setStatusCode(404, 'error, login incorrect');
                $response->headers->set('Content-Type', 'application/json');
                // Allow all websites
                $response->headers->set('Access-Control-Allow-Origin', '*');
                return $response;
            }
        }
    }
}