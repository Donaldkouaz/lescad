<?php

namespace lescad\platformeBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * formationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class formationRepository extends \Doctrine\ORM\EntityRepository {

    public function FindAllWithCategorie() {
        $qb = $this
                ->createQueryBuilder('f')
                ->leftJoin('f.categorie', 'c')
                ->addSelect('c')
        ;

        return $qb
                        ->getQuery()
                        ->getResult()
        ;
    }

    public function FindAllWithMatieres() {
        $qb = $this
                ->createQueryBuilder('f')
                ->leftJoin('f.matieres', 'm')
                ->addSelect('m')
        ;

        return $qb
                        ->getQuery()
                        ->getResult()
        ;
    }

    public function FindByCat($slug, $page, $nbre) {
        $qb = $this
                ->createQueryBuilder('f')
                ->leftJoin('f.categorie', 'c')
                ->addSelect('c')
                ->leftJoin('f.matieres', 'm')
                ->addSelect('m')
                ->where('c.slug = :slug')
                ->setParameter('slug', $slug)
                ->getQuery()
        ;
        $qb
                // On définit l'annonce à partir de laquelle commencer la liste
                ->setFirstResult(($page - 1) * $nbre)
                // Ainsi que le nombre d'annonce à afficher sur une page
                ->setMaxResults($nbre)
        ;

        // Enfin, on retourne l'objet Paginator correspondant à la requête construite
        return new Paginator($qb, true);
    }

    public function GetAll($page, $nbre) {
        $qb = $this
                ->createQueryBuilder('f')
                ->leftJoin('f.matieres', 'm')
                ->addSelect('m')
                ->getQuery()
        ;
        $qb
                // On définit l'annonce à partir de laquelle commencer la liste
                ->setFirstResult(($page - 1) * $nbre)
                // Ainsi que le nombre d'annonce à afficher sur une page
                ->setMaxResults($nbre)
        ;

        // Enfin, on retourne l'objet Paginator correspondant à la requête construite
        return new Paginator($qb, true);
    }
    
    public function FindOneCompleteBySlug($slug) {
        $qb = $this
                ->createQueryBuilder('f')
                ->leftJoin('f.categorie', 'c')
                ->addSelect('c')
                ->leftJoin('f.matieres', 'm')
                ->addSelect('m')
                ->where('f.slug = :slug')
                ->setParameter('slug', $slug)
        ;

        return $qb
                        ->getQuery()
                        ->getOneOrNullResult()
        ;
    }

    public function FindAllComplete() {
        $qb = $this
                ->createQueryBuilder('f')
                ->leftJoin('f.categories', 'c')
                ->addSelect('c')
                ->leftJoin('f.matieres', 'm')
                ->addSelect('m')
        ;

        return $qb
                        ->getQuery()
                        ->getResult()
        ;
    }
    
    public function FindAllCompleteByCategorie($cat) {
        $qb = $this
                ->createQueryBuilder('f')
                ->leftJoin('f.categorie', 'c')
                ->addSelect('c')
                ->leftJoin('f.matieres', 'm')
                ->addSelect('m')
                ->where('c.nom = :cat')
                ->setParameter('cat', $cat)
        ;

        return $qb
                        ->getQuery()
                        ->getResult()
        ;
    }
}
