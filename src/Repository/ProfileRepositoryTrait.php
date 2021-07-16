<?php

namespace App\Repository;

use App\Entity\User;

Trait ProfileRepositoryTrait
{
    /**
     * @param $role string optional nom d'un rôle comme 'ROLE_ADMIN', 'ROLE_STUDENT', etc
     * @return App\Entity\Book
     */
    public function findOneByUser(User $user, string $role = '')
    {
        return $this->createQueryBuilder('p')
        ->innerJoin('p.user', 'u')
        ->andWhere('p.user = :user')
        ->andWhere('u.roles LIKE :role')
        ->setParameter('user', $user)
        ->setParameter('role', "%{$role}%")
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }
}
