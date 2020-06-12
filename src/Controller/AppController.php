<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Form\AppType;
use App\Repository\ObjetRepository;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AppController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(ObjetRepository $objetRepository)
    {   
      // $objet = $this->getDoctrine()->getRepository(Objet::class)->findAll();
      
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'objets' => $objetRepository->findAll()
            //json_encode($objet)
        ]);
    }

/**
 *@Route("/ajaxsearch", name="app_json")
 */
public function jsonOfAllObjects(Request $request){
   $search = $request->query->get('name');

    $objets = $this->getDoctrine()->getRepository(Objet::class)->findBy($search);
 //   dd($objets);
        $objetsList = [];
    
foreach($objets as $objet){
        $objet =['name' => $objet->getName()];
        $objetsList[] = $objet;
    }
    return new JsonResponse($objetsList);
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
