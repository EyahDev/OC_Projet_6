<?php

namespace App\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Récupération des utilisateurs sans l'administrateur
     *
     * @return Paginator
     */
    public function getUsersExceptAdmin($firstResult, $perPage) {
        // Création de l'alias
        $qb = $this->createQueryBuilder('u');

        // Création de la requête personnalisée
        $query = $qb->where('u.roles LIKE :roles')->setParameter('roles', '%ROLE_USER%')->setFirstResult($firstResult)->setMaxResults($perPage);

        $paginator = new Paginator($query);

        // Récupération du résultat
        return $paginator;
    }
}
