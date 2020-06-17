<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Material;
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
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'objets' => $objetRepository->findAll()

        ]);
    }

    /**
     *@Route("/ajaxsearch", name="app_json")
     */
    public function jsonOfAllObjects(Request $request)
    {
        //récupère la valeur du champ au fur et à mesure de la frappe
        $search = $request->query->get('name');
        //génère les résultats de la recherche au fur et à mesure de la frappe en fonction du nom de l'objet
        $objets = $this->getDoctrine()->getRepository(Objet::class)->findBySearchString($search);
        //prépare le tableau de résultat
        $objetsList = [];
        //Remplit le tableau de tous les objets compatibles avec la frappe
        foreach ($objets as $objet) {
            $name = $objet->getNewName();
            $material =  $objet->getMaterialId()->getName();
            $category = $objet->getUseId()->getName();
            $objet =    [
                'name' => $name,
                'material' => $material,
                'category' => $category,
            ];

            $objetsList[] = $objet;
        }

        //dd($objetsList);
        //dd(new JsonResponse($objetsList));

        return new JsonResponse($objetsList);
    }

    /**
     * @Route("/search", name="app_search", methods={"GET"})
     * @param Request $request
     */
    public function search(Request $request)
    {
        // On récupère l'input de recherche du formulaire, le name=objetName
        $searchObjet = $request->query->get('objetName');
        //dd($searchObjet);

        // On recherche un objet par son nom
        $objet = $this->getDoctrine()->getRepository(Objet::class)->findOneBy(["newName" => $searchObjet]);


        // Si un objet est trouvé
        if ($objet) {

            $consignesTriByMaterial = $objet->getMaterialId();
            $consignesTriByUse = $objet->getUseId();
            $name = $objet->getName();
            $id = $objet->getId();

            return $this->render('result/index.html.twig', [
                'consignesTriByMaterial' => $consignesTriByMaterial,
                'consignesTriByUse' => $consignesTriByUse,
                'name' => $name,
                'id' => $id
            ]);
        }

        // Sinon, on redirige en page d'accueil
        return $this->redirectToRoute("app_index");
    }

    /**
     * @Route("/rgpd", name="app_rgpd")
     * 
     */

     public function rgpd(){
         return $this->render('app/rgpd.html.twig');
     }
}
