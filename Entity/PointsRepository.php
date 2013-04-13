<?php
/**
 * User: etorras
 * Date: 9/04/13
 */

namespace PS\Bundle\PSPointsBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PointsRepository extends EntityRepository
{
    function findPointsByDateJoinedUser($user, \DateTime $initialDate, \DateTime $endDate) {
        return $this->getEntityManager()
            ->createQuery('
                SELECT p FROM PSPSPointsBundle:Points p
                JOIN p.user u
                WHERE p.user = :user
                AND p.creationDate BETWEEN :initialDate AND :endDate
            ')
            ->setParameter("initialDate", $initialDate)
            ->setParameter("endDate", $endDate)
            ->setParameter("user", $user)
            ->getResult();
    }

    function findTotalPointsByUser($user) {
        return $this->getEntityManager()
            ->createQuery('SELECT SUM(p.points) FROM PSPSPointsBundle:Points p WHERE p.user = :user')
            ->setParameter("user", $user)
            ->getSingleScalarResult();
    }

    function findTotalPointsByUserAndDate($user, \DateTime $initialDate, \DateTime $endDate) {
        return $this->getEntityManager()
            ->createQuery('
                SELECT SUM(p.points)
                FROM PSPSPointsBundle:Points p
                WHERE p.user = :user
                AND p.creationDate BETWEEN :initialDate AND :endDate
            ')
            ->setParameter("initialDate", $initialDate)
            ->setParameter("endDate", $endDate)
            ->setParameter("user", $user)
            ->getSingleScalarResult();
    }

}