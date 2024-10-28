<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/lista', name: 'lista')]
    public function listAuth(AuthorRepository $authorRepo): Response
    {
        //$authorRepo=$doctrine->getRepository(Author::class);
        $authors = $authorRepo->findAll();

        return $this->render('author/lista.html.twig', [
            'authors' => $authors
        ]);
    }

    #[Route('/add_static/{username}/{email}', name: 'add_static')]
    public function addStaticAuthor(ManagerRegistry $doctrine, string $username, string $email): Response
    {
        $entityManager = $doctrine->getManager();

        $author = new Author();
        $author->setUsername($username);
        $author->setEmail($email);

        $entityManager->persist($author);
        $entityManager->flush();

        return $this->render('author/added.html.twig', [
            'author' => $author
        ]);
    }


    #[Route('/show/{id}', name: 'showauth')]
    public function ShowAuth(ManagerRegistry $doctrine, $id): Response
    {
        $authorRepo = $doctrine->getRepository(Author::class);
        $author = $authorRepo->find($id);
        return $this->render('author/showA.html.twig', [
            'author' => $author
        ]);
    }
    #[Route('/delete/{id}', name: 'deleteauth')]
    public function deleteAuth(ManagerRegistry $doctrine, $id): Response
    {
        $authorRepo = $doctrine->getRepository(Author::class);
        $author = $authorRepo->find($id);
        $em = $doctrine->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('lista');
    }
    #[Route('/addauthor', name: 'add_author')]
    public function addAuthor(ManagerRegistry $doctrine, Request $request): Response
    {
        $author = new Author(); // init Author
        $form = $this->createForm(AuthorType::class, $author); //form creation
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            //Persistence de données
            $em = $doctrine->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('lista');
        }
        return $this->render('author/addauthor.html.twig', [
            'authform' => $form->createView()
        ]);
    }
    #[Route('/updateauthor/{id}', name: 'update_author')]
    public function updateAuthor($id, ManagerRegistry $doctrine, Request $request): Response
    { /// trouver l'auteur qu'on veut modifier
        $authorRepo = $doctrine->getRepository(Author::class);
        $author = $authorRepo->find($id);
        $form = $this->createForm(AuthorType::class, $author); //form creation
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //Persistence de données
            $em = $doctrine->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('lista');
        }
        return $this->render('author/addauthor.html.twig', [
            'authform' => $form->createView()
        ]);
    }
}
