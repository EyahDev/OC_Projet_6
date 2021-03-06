<?php

namespace App\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * CourseCardHistoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CourseCardHistoryRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Récupération de l'historique par utilisateur
     *
     * @param $firstResult
     * @param $perPage
     * @param $id
     * @return Paginator
     */
    public function getHistoryByUser($firstResult, $perPage, $id) {
        // Création de l'alias
        $qb = $this->createQueryBuilder('cch');

        // Création de la requête personnalisée
        $query = $qb->where('cch.user = :user')->orderBy('cch.countDate', 'DESC')
            ->setParameter('user', $id)
            ->setFirstResult($firstResult)->setMaxResults($perPage);

        $paginator = new Paginator($query);

        // Récupération du résultat
        return $paginator;
    }
}
