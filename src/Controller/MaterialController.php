<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CollectionPointType;
use App\Entity\Material;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/material")
 */
class MaterialController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="material_index", methods={"GET"})
     */
    public function index(MaterialRepository $materialRepository): Response
    {
        return $this->render('material/index.html.twig', [
            'materials' => $materialRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}/searchMaterialPoint", name="material_search", methods={"GET"})
     */
    public function searchCollectionPointTypeByMaterial(Material $material, Request $request)
    {
        $materialName = $material->getName();
        $collectionPointTypeId= $material -> getCollectionPointType();
        $collectionPointType = $this->getDoctrine()->getRepository(CollectionPointType::class)->find($collectionPointTypeId)->getType();

       
        $response = [
            'materialOrUsage' => $materialName,
            'collectionPointType' => $collectionPointType
        ];

       
        return $this->render('map/index.html.twig', [
            'response' => $response
        ]);
    }

    /**
     *@IsGranted("ROLE_ADMIN")
     * @Route("/new", name="material_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $material = new Material();
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($material);
            $entityManager->flush();

            return $this->redirectToRoute('material_index');
        }

        return $this->render('material/new.html.twig', [
            'material' => $material,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="material_show", methods={"GET"})
     */
    public function show(Material $material): Response
    {
        return $this->render('material/show.html.twig', [
            'material' => $material,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/edit", name="material_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Material $material): Response
    {
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('material_index');
        }

        return $this->render('material/edit.html.twig', [
            'material' => $material,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="material_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Material $material): Response
    {
        if ($this->isCsrfTokenValid('delete' . $material->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($material);
            $entityManager->flush();
        }

        return $this->redirectToRoute('material_index');
    }
}
