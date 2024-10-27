<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
function CountNbBooks(){
    
    $query=$this->getEntityManager()
    ->createQuery('select count(b) from App\Entity\Book b 
    where b.category=:c')
    ->setParameter('c','Mystery')
    ->getSingleScalarResult();
    return $query;
}
// function findDate(){
//     $em=$this->getEntityManager();
//     return $em->createQuery('select b from App\Entity\Book b 
//     where b.publicationDate between ?1 and ?2')
//     // ->setParameter(1,"2024-10-24")
//     // ->setParameter(2,"2024-10-27")
//     ->setParameters([1=>"2024-10-24",2=>"2024-10-27"])
//     ->getResult();
// }
function findDate($d1,$d2){
    $em=$this->getEntityManager();
    return $em->createQuery('select b from App\Entity\Book b 
    where b.publicationDate between ?1 and ?2')
    // ->setParameter(1,"2024-10-24")
    // ->setParameter(2,"2024-10-27")
    ->setParameters([1=>$d1,2=>$d2])
    ->getResult();
}
function AuthorByBook($username){
    return $this->createQueryBuilder('b')
    ->join('b.authors','a')
    ->addSelect('a')
    ->where('a.username=:u')
    ->setParameter('u',$username)
    ->getQuery()->getResult();

}
}
