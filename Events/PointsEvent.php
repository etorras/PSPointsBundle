<?php
/**
     * User: etorras
     * Date: 7/04/13
     */

namespace PS\Bundle\PSPointsBundle\Events;

use PS\Bundle\PSPointsBundle\Model\Points;
use Symfony\Component\EventDispatcher\Event;

/**
 * Event dispatched in Points Manager
 */

class PointsEvent extends Event
{
    /**
     * Points associated to the event.
     *
     * @var Points
     */
    protected $points;

    /**
     * Constructor
     *
     * @param \PS\Bundle\PSPointsBundle\Model\Points $points
     * @internal param \PS\Bundle\PSPointsBundle\Model\Points $points
     */
    public function __construct(Points $points)
    {
        $this->points = $points;
    }

    /**
     * Set the Points object associated to the event
     *
     * @param  Points $points
     * @return PointsEvent
     */
    public function setPoints(Points $points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get the Points object associated to the event
     * @return Points
     */
    public function getPoints()
    {
        return $this->points;
    }
}
