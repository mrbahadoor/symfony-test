<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EquipmentController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(Request $request){
        return new JsonResponse([
            'action' => 'index', 
            'time' => time(),
        ]);
    }
}