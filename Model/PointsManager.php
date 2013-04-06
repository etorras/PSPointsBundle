<?php
/**.
 * User: etorras
 * Date: 31/03/13
 * Time: 17:07
 */

namespace PS\Bundle\PSPointsBundle\Model;

use Doctrine\Tests\Common\Annotations\Null;
use PS\Bundle\PSPointsBundle\Entity\Points;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PS\Bundle\PSPointsBundle\Model\PointsInterface;

/**
 * Points manager.
 * Access point to all the bundle's features and factory service to create database objects
 */
class PointsManager implements PointsInterface
{
    /**
     * ObjectManager to access the database, by ORM
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $objectManager;

    /**
     * Constructor.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager        $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param $pointsToAdd
     * @param $sourcePoints
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @throws \Exception
     */
    public function savePoints($pointsToAdd, $sourcePoints, UserInterface $user)
    {
        echo "Guardando " . $pointsToAdd . " puntos";
        if (null === $user) {
            throw new \Exception("User can not be null");
        }
        $points = New Points();
        $points->setPoints($pointsToAdd);
        $points->setSource($sourcePoints);
        $points->setCreationDate(new \DateTime());
        $points->setUser($user);

        $this->objectManager->persist($points);

        $this->objectManager->flush();

    }

    /**
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return int
     */
    public function getPointsByUser(UserInterface $user)
    {
        $total = 0;
        $points = $this->objectManager->getRepository('PSPSPointsBundle:Points')->findAll();
        foreach ($points as $p) {
            $total += $p->getPoints();
        }
        return $total;
    }

    /**
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @param $initialDate
     * @param $endDate
     */
    public function getPointsByUserAndDate(UserInterface $user, \DateTime $initialDate, \DateTime $endDate)
    {

    }

}