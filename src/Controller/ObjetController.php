<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Material;
use App\Entity\Objet;
use App\Form\ObjetType;
use App\Repository\ObjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/objet")
 */
class ObjetController extends AbstractController
{
    /**
     * Return invalid object ordered by id desc
     *@IsGranted("ROLE_USER")
     * @Route("/invalidObjects", name="objet_invalidObjects", methods={"GET", "POST"})
     */
    public function invalidObjects(ObjetRepository $objetRepository): Response
    {
        return $this->render('objet/invalidObjects.html.twig', [
            'objets' => $objetRepository->findByInvalidObjects(),
        ]);
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/", name="objet_index", methods={"GET"})
     */
    public function index(ObjetRepository $objetRepository): Response
    {
        return $this->render('objet/index.html.twig', [
            'objets' => $objetRepository->findAll(),
        ]);
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/validateAllChecked", name="objet_validateAllChecked", methods={"GET","POST"})
     */
    public function validateAllChecked(Request $request, ObjetRepository $objetRepository)

    {
        $objets = $objetRepository->findAll();
        //dd($objet);

        if (isset($_POST['objetValidation']) && isset($_POST['objetDelete']) && !empty(array_intersect($_POST['objetValidation'], $_POST['objetDelete']))) {

            $this->addFlash(
                'danger',
                "Attention à ne cocher qu'une case par objet: valider ou supprimer!"
            );
            
        } else {

            if (isset($_POST['objetValidation'])) {
                // dd($_POST["objetValidation"]);

                foreach ($_POST['objetValidation'] as $id) {

                    $arrayOfNewObjet = $objetRepository->findById($id);
                    // dd($arrayOfNewObjet);

                    foreach ($arrayOfNewObjet as $newObjet) {
                        // dd($newObjet);                            
                        $newObjet->setValide(1);
                        $this->getDoctrine()->getManager()->flush();
                    }
                }
            }

            if (isset($_POST['objetDelete'])) {
                //dd($_POST["objetDelete"]);

                foreach ($_POST['objetDelete'] as $id) {

                    $arrayOfNewObjet = $objetRepository->findById($id);

                    foreach ($arrayOfNewObjet as $newObjet) {
                        // dd($objet);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->remove($newObjet);
                        $entityManager->flush();
                    }
                }
            }
        }
        return $this->redirectToRoute('objet_invalidObjects');
    }




    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/validateObjects", name="objet_validate", methods={"GET"})
     */
    public function validateObject(Request $request, Objet $objet)
    {

        // dd($objet);
        $objet->setValide(1);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('objet_invalidObjects');
    }

    /**
     * @Route("/new", name="objet_new", methods={"GET","POST"})
     */
    public function new(Request $request, ObjetRepository $objetRepository): Response
    {
        $newObjet = new Objet();

        $objets = $objetRepository->findAll();

        $form = $this->createForm(ObjetType::class, $newObjet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newName = $newObjet->getName();
            $newUseId = $newObjet->getUseId();
            $newMaterialId = $newObjet->getMaterialId();
            $material = $this->getDoctrine()->getRepository(Material::class)->find($newMaterialId)->getName(); 
            $category= $this->getDoctrine()->getRepository(Category::class)-> find($newUseId)->getName(); 
            $newName= $newName. ' ('.$material. ', '.$category. ')';
           // dd($newName);
            foreach ($objets as $objet) {

                
                $materialId = $objet->getMaterialId();
                $useId = $objet->getUseId();                
                $name = $objet->getName();
              
                // dd($newName, $newMaterialId, $materialId);

                if ($name == $newName && $materialId == $newMaterialId && $useId == $newUseId) {

                    $this->addFlash(
                        'invalid',
                        "Cet objet existe déjà"
                    );

                    return $this->redirectToRoute('objet_new');
                }
            }
            $newObjet -> setName($newName);

            
            //dd($newObjet);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newObjet);
            $entityManager->flush();
            $this->addFlash(
                'success',
                "Votre objet a bien été enregistré. Il sera validé par nos équipes dès que possible."
            );

            return $this->redirectToRoute('app_index');
        }

        return $this->render('objet/new.html.twig', [
            'objet' => $newObjet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="objet_show", methods={"GET"})
     */
    public function show(Objet $objet): Response
    {
        return $this->render('objet/show.html.twig', [
            'objet' => $objet,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/edit", name="objet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Objet $objet): Response
    {
        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('objet_index');
        }

        return $this->render('objet/edit.html.twig', [
            'objet' => $objet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="objet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Objet $objet): Response
    {
        if ($this->isCsrfTokenValid('delete' . $objet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($objet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('objet_index');
    }
}
