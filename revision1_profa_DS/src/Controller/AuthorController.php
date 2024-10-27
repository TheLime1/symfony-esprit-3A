<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Entity\Author;
use App\Form\AuthorType;
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
    #[Route('List/')]
    function ListAuthor(){
        $authors = array(
            array('id' => 1, 'picture' => '/img/téléchargement.jfif','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
            );
        return $this->render('author/list.html.twig',[
            "auth"=>$authors
        ]);
            
    }
    #[Route('/Detail/{i}',name:'DD')]
    function Detail($i){
        return $this->render(
            'author/detail.html.twig',
            ['ii'=>$i]
        );
    }
    #[Route('/Affiche',name:"Aff")]
    function Affiche(AuthorRepository $repo){
        //$authors=$repo->findAll();
        return $this->render(
            'author/Affiche.html.twig',
            //['auth'=>$authors]);
            ['auth'=>$repo->findAll()]);
    }
    #[Route('/Ajout')]
    function Ajout(Request $request,ManagerRegistry $manager){
        $author=new Author();
        $form=$this->createForm(AuthorType::class,$author)
        ->add('Ajout',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$manager->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute("Aff");
        }
        return $this->render('author/ajout.html.twig',
    ['form'=>$form->createView()]);
    }
    #[Route('Det/{i}',name:"Det")]
    // function Det(Author $auth){
     function Det($i,AuthorRepository $repo){
         $author=$repo->find($i);
        return $this->render('author/det.html.twig',
    ['ii'=>$author]);
    }
    #[Route('Del/{i}',name:"Del")]
    // function Det(Author $auth){
     function Del($i,AuthorRepository $repo,ManagerRegistry $manager){
         $author=$repo->find($i);
         //Supp author
         $em=$manager->getManager();
         $em->remove($author);
         $em->flush();
        return $this->redirectToRoute('Aff');
    }
    #[Route('/Update/{i}', name:'Up')]
    function Update($i,Request $request,ManagerRegistry $manager,AuthorRepository $repo){
        // $author=new Author();
        $author=$repo->find($i);
        $form=$this->createForm(AuthorType::class,$author)
        ->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$manager->getManager();
            // $em->persist($author);
            $em->flush();
            return $this->redirectToRoute("Aff");
        }
        return $this->render('author/ajout.html.twig',
    ['form'=>$form->createView()]);
    }
    #[Route('/Tri')]
    function Tri(AuthorRepository $repo){
        
        return $this->render(
            'author/Affiche.html.twig',
            
            ['auth'=>$repo->TrieMail()]);
    }
 
}
