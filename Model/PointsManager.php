<?php
/**.
 * User: etorras
 * Date: 31/03/13
 * Time: 17:07
 */

namespace PS\Bundle\PSPointsBundle\Model;

use Doctrine\Tests\Common\Annotations\Null;
use PS\Bundle\PSPointsBundle\Entity\Points as EntityPoints;
use PS\Bundle\PSPointsBundle\Events\PointsEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PS\Bundle\PSPointsBundle\Events\Events;
use Symfony\Component\EventDispatcher\Event;
use PS\Bundle\PSPointsBundle\Model\PointsInterface;
use PS\Bundle\PSPointsBundle\Model\AboutInterface;

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
     * @param $params
     * @throws \InvalidArgumentException
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
        if (!$params['about'] instanceof AboutInterface) {
            throw new \Exception("About must be an instance of AboutInterface");
        }
        try {
            $aboutMetadata = $this->objectManager->getClassMetadata(get_class($params['about']));
        } catch (\Exception $e) {
            throw new \InvalidArgumentException("Invalid object");
        }

        $ids = $aboutMetadata->getIdentifierValues($params['about']);

        if (count($ids) == 0) {
            // Si el objeto no existe en bbdd lo creamos
            $this->objectManager->persist($params['about']);
            $this->objectManager->flush();
        }

        //Set the "about" object into the enquiry one
        $points = New EntityPoints();
        $points->setAbout($params['about']);
        $points->setPoints($params['points']);
        $points->setSource($params['source']);
        $points->setCreationDate(new \DateTime());
        $points->setUser($params['user']);

        //Dispatch event and get the $points object, in case the listener change it
        $event = new PointsEvent($points);
        $this->dispatcher->dispatch(Events::PRE_PERSIST_POINTS, $event);

        $points = $event->getPoints();

        $this->objectManager->persist($points);
        $this->objectManager->flush();

        //Dispatch event to inform object has persisted
        $this->dispatcher->dispatch(Events::POST_PERSIST_POINTS, $event);

    }

}
