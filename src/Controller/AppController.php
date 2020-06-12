<?php

namespace App\Controller;

use App\Entity\Objet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index()
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

/**
* @Route("/search", name="app_search", methods={"GET"})
* @param Request $request
*/
public function search(Request $request) {
    // On récupère l'input de recherche du formulaire, le name=objetName
    $searchObjet = $request->query->get('objetName');

    // On recherche un objet par son nom
    $objet = $this->getDoctrine()->getRepository(Objet::class)->findOneBy(["name" => $searchObjet]);


    // Si un objet est trouvé
    if ($objet) {

        $consignesTriByMaterial = $objet->getMaterialId();
        $consignesTriByUse = $objet->getUseId();

        return $this->render('result/index.html.twig', [
            'consignesTriByMaterial' => $consignesTriByMaterial,
            'consignesTriByUse' => $consignesTriByUse,
        ]);
    }

    // Sinon, on redirige en page d'accueil
    return $this->redirectToRoute("app_index");
}
}
