<?php
/**.
 * User: etorras
 * Date: 31/03/13
 * Time: 17:07
 */

namespace PS\Bundle\PSPointsBundle\Model;

use Doctrine\Tests\Common\Annotations\Null;
use PS\Bundle\PSPointsBundle\Entity\UserPoints;
use PS\Bundle\PSPointsBundle\Events\UserPointsEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PS\Bundle\PSPointsBundle\Events\Events;
use Symfony\Component\EventDispatcher\Event;
use PS\Bundle\PSPointsBundle\Model\UserPointsInterface;

/**
 * Points manager.
 * Access point to all the bundle's features and factory service to create database objects
 */
class UserPointsManager implements UserPointsInterface
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
     * @param $params
     * @throws \Exception
     */
    public function create($params)
    {
        if (null === $params['user']) {
            throw new \Exception("User can not be null");
        }
        if (!$params['user'] instanceof UserInterface) {
            throw new \Exception("User must be an instance of UserInterface");
        }
        $userPoints = New UserPoints();
        $userPoints->setLastUpdate(new \DateTime());
        $userPoints->setPoints($params['points']);
        $userPoints->setUser($params['user']);

        //Dispatch event and get the $points object, in case the listener change it
        $event = new UserPointsEvent($userPoints);
        $this->dispatcher->dispatch(Events::PRE_PERSIST_USERPOINTS, $event);

        $userPoints = $event->getUserPoints();

        $this->objectManager->persist($userPoints);
        $this->objectManager->flush();

        //Dispatch event to inform object has persisted
        $this->dispatcher->dispatch(Events::POST_PERSIST_USERPOINTS, $event);

    }
    public function update($params, UserPoints $userPoints)
    {
        if (null === $params['user']) {
            throw new \Exception("User can not be null");
        }
        if (!$params['user'] instanceof UserInterface) {
            throw new \Exception("User must be an instance of UserInterface");
        }

        $userPoints->setLastUpdate(new \DateTime());
        $userPoints->setPoints($params['points']);
        $userPoints->setUser($params['user']);

        //Dispatch event and get the $points object, in case the listener change it
        $event = new UserPointsEvent($userPoints);
        $this->dispatcher->dispatch(Events::PRE_PERSIST_USERPOINTS, $event);

        $userPoints = $event->getUserPoints();

        $this->objectManager->persist($userPoints);
        $this->objectManager->flush();

        //Dispatch event to inform object has persisted
        $this->dispatcher->dispatch(Events::POST_PERSIST_USERPOINTS, $event);

    }
}
