<?php
/**
 * Created by JetBrains PhpStorm.
 * User: etorras
 * Date: 11/04/13
 * Time: 23:59
 * To change this template use File | Settings | File Templates.
 */

namespace PS\Bundle\PSPointsBundle\Events;


use PS\Bundle\PSPointsBundle\Model\UserPoints;
use Symfony\Component\EventDispatcher\Event;

/**
 * Event dispatched in Points Manager
 */

class UserPointsEvent extends Event
{
    /**
     * Points associated to the event.
     *
     * @var userPoints
     */
    protected $userPoints;

    /**
     * Constructor
     *
     * @param \PS\Bundle\PSPointsBundle\Model\UserPoints $userPoints
     * @internal param \PS\Bundle\PSPointsBundle\Model\UserPoints $userPoints
     */
    public function __construct(UserPoints $userPoints)
    {
        $this->userPoints = $userPoints;
    }

    /**
     * Set the Points object associated to the event
     *
     * @param \PS\Bundle\PSPointsBundle\Model\UserPoints $userPoints
     * @internal param \PS\Bundle\PSPointsBundle\Events\Points $points
     * @return PointsEvent
     */
    public function setUserPoints(UserPoints $userPoints)
    {
        $this->userPoints = $userPoints;

        return $this;
    }

    /**
     * Get the Points object associated to the event
     * @return UserPoints
     */
    public function getUserPoints()
    {
        return $this->userPoints;
    }
}
