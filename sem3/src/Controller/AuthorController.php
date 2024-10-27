<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('author/name/{value}', name: 'app_author_show', methods: ['GET'], defaults: ["value" => "Victor Hugo"])]
    public function showAuthor($value): Response
    {
        return $this->render('author/show.html.twig', [
            'authorName' => $value,
        ]);
    }

    #[Route('author/liste', name: 'app_author_list')]
    public function listAuthor(): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '../../assets/images/1.jpeg', 'name' => 'Victor Hugo'),
            array('id' => 2, 'picture' => '../../assets/images/2.jpeg', 'name' => 'Emile Zola'),
            array('id' => 3, 'picture' => '../../assets/images/3.jpeg', 'name' => 'Guy de Maupassant'),
        );
        return $this->render('author/liste.html.twig', [
            'authors' => $authors,
        ]);
    }
}
