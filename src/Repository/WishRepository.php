<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wish>
 *
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry) {

        parent::__construct($registry, Wish::class);
    }

    public function getWishes()
    {
        $queryBuilder = $this->createQueryBuilder('wish')
            ->andWhere('wish.isPublished = :is_published')
            ->setParameter('is_published', true)
            ->orderBy('wish.dateCreated', 'DESC');

        $queryBuilder->setMaxResults(20);

        return $queryBuilder->getQuery()->getResult();
    }

    public function getWishById(int $id)
    {
        $queryBuilder = $this->createQueryBuilder('wish')
            ->andWhere('wish.id = :id')
            ->setParameter('id', $id)
            ->andWhere('wish.isPublished = :is_published')
            ->setParameter('is_published', true);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function findPublishedWishesWithCategories(): ?array
    {
        //création d'un query builder et d'un alias de la table Wish
        $queryBuilder = $this->createQueryBuilder('w');
        //jointure avec la table Category
        //plus sélection des données
        $queryBuilder
            ->join( 'w.category', 'c')
            ->addSelect('c');

        //clauses where (il faut set le paramètre avec la valeur que l'on souhaite) et order by
        $queryBuilder
            ->andWhere('w.isPublished = :is_published')
            ->setParameter('is_published', true)
            ->orderBy('w.dateCreated', 'DESC');

        //récupération de l'objet query de doctrine
        $query = $queryBuilder->getQuery();
        //retourne le résultat de la requête
        return $query->getResult();
    }



}