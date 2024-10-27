<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

#[Route('book/')]
class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('Ajout/')]
    function Ajout(Request $req,ManagerRegistry $manager){
        $book=new Book();
        $form=$this->createForm(BookType::class,$book)
        ->add('Ajout',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$manager->getManager();
            $book->setEnabled(true);
            $nb=$book->getAuthors()->getNbBooks()+1;
            $book->getAuthors()->setNbBooks($nb);
            $em->persist($book);
            $em->flush();
            // return new Response('Ajout avec succés');
            return $this->redirectToRoute('Affiche');
        }
        return $this->render('book/Ajout.html.twig',
    ['ff'=>$form->createView()]);

    }
    #[Route('Affiche/',name:'Affiche')]
    function Affiche(BookRepository $repo){
        return $this->render('book/Affiche.html.twig',
        ['book'=>$repo->findAll()]);
    }
    #[Route('search/',name:"SearchRef")]
    function SearchRef(Request $request,BookRepository $repo){
        $ref=$request->get('rr');
        $book=$repo->findByRef($ref);
        return $this->render('book/Affiche.html.twig',
        ['book'=>$book]); 

    }
    #[Route('Nb/')]
    function NbBooks(BookRepository $repo){
        $nb=$repo->CountNbBooks();
        return new Response('Le nombre est: <b>'.$nb.'</b>');
    }
    // #[Route('date/',name:"DateBook")]
    // function DateBooks(BookRepository $repo){
    //     $bb=$repo->findDate();
    //     return $this->render('book/Affiche.html.twig',
    //     ['book'=>$bb]); 

    // }
    #[Route('date/',name:"DateBook")]
    function DateBooks(BookRepository $repo,Request $req){
        $date1=$req->get('dd');
        $date2=$req->get('df');
        $bb=$repo->findDate($date1,$date2);
        return $this->render('book/Affiche.html.twig',
        ['book'=>$bb]); 

    }
}
