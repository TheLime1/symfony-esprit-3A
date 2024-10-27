<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/Home')]
class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /*#[Route('/aff/{classe}')]
    function aff($classe){
        return new Response("Bonjour <b><i>".$classe."</i></b>");
    }*/
    #[Route('/aff/{classe}')]
    function aff($classe){
        return $this->render('home/aff.html.twig',[
            'c'=>$classe
        ]);
    }
}
