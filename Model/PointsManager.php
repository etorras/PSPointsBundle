<?php
/**.
 * User: etorras
 * Date: 31/03/13
 * Time: 17:07
 */

namespace PS\Bundle\PSPointsBundle\Model;

use Doctrine\Tests\Common\Annotations\Null;
use PS\Bundle\PSPointsBundle\Entity\Points;
use PS\Bundle\PSPointsBundle\Entity\UserPoints;
use PS\Bundle\PSPointsBundle\Events\PointsEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PS\Bundle\PSPointsBundle\Events\Events;
use Symfony\Component\EventDispatcher\Event;
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
     * Dispatcher for the events
     *
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Construct
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     */
    public function __construct(ObjectManager $objectManager, EventDispatcherInterface $dispatcher)
    {
        $this->objectManager = $objectManager;
        $this->dispatcher = $dispatcher;
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

        //Dispatch event and get the $points object, in case the listener change it
        $event = new PointsEvent($points);
        $this->dispatcher->dispatch(Events::PRE_PERSIST_POINTS, $event);

        $points = $event->getPoints();

        $this->objectManager->persist($points);
        $this->objectManager->flush();

        //Dispatch event to inform object has persisted
        $this->dispatcher->dispatch(Events::POST_PERSIST_POINTS, $event);

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

    public function computePoints($points, UserInterface $user)
    {
        if (null === $user) {
            throw new \Exception("User can not be null");
        }
        $userPoints = $this->objectManager->getRepository('PSPSPointsBundle:UserPoints')->find($user);
        if (null == $userPoints) {
            $userPoints = New UserPoints();
        }
        $userPoints->setLastUpdate(new \DateTime());
        $userPoints->setUser($user);
        $userPoints->setPoints($points);

        $this->objectManager->persist($userPoints);
        $this->objectManager->flush();

    }
}