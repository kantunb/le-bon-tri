<?php

namespace App\Controller;

use App\Entity\CollectionPointType;
use App\Entity\Material;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends AbstractController
{
    /**
     * @Route("/result", name="result")
     */
    public function index()
    {
        return $this->render('result/index.html.twig', [
            'controller_name' => 'ResultController',
            
        ]);
    }

  
}
