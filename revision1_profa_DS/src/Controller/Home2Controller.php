<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/Home2')]
class Home2Controller extends AbstractController
{
    #[Route('/home2', name: 'app_home2')]
    public function index(): Response
    {
        return $this->render('home2/index.html.twig', [
            'controller_name' => 'Home2Controller',
        ]);
    }
    #[Route('/aff')]
    function aff(){
        return new Response("Bonjour <b><i>3A44</i></b>");

    }
}
