<?php

namespace App\Controller;

use App\Entity\CollectionPoint;
use App\Form\CollectionPointType;
use App\Repository\CollectionPointRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("ROLE_USER")
 * @Route("/collection/point")
 */
class CollectionPointController extends AbstractController
{
    /**
     * @Route("/", name="collection_point_index", methods={"GET"})
     */
    public function index(CollectionPointRepository $collectionPointRepository): Response
    {
        return $this->render('collection_point/index.html.twig', [
            'collection_points' => $collectionPointRepository->findAll(),
        ]);
    }


   /**
     * @Route("/new", name="collection_point_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $collectionPoint = new CollectionPoint();
        $form = $this->createForm(CollectionPointType::class, $collectionPoint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($collectionPoint);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Votre Point de collecte a bien été enregistré. Il sera validé par nos équipes dès que possible."
            );
            return $this->redirectToRoute('app_index');
        }

        return $this->render('collection_point/new.html.twig', [
            'collection_point' => $collectionPoint,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_point_show", methods={"GET"})
     */
    public function show(CollectionPoint $collectionPoint): Response
    {
        return $this->render('collection_point/show.html.twig', [
            'collection_point' => $collectionPoint,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="collection_point_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CollectionPoint $collectionPoint): Response
    {
        $form = $this->createForm(CollectionPointType::class, $collectionPoint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('collection_point_index');
        }

        return $this->render('collection_point/edit.html.twig', [
            'collection_point' => $collectionPoint,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collection_point_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CollectionPoint $collectionPoint): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collectionPoint->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($collectionPoint);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collection_point_index');
    }
}
