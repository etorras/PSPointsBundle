<?php
/**
 * User: etorras
 * Date: 7/04/13
 */

namespace PS\Bundle\PSPointsBundle\EventListener;

use PS\Bundle\PSPointsBundle\Model\PointsManager;
use PS\Bundle\PSPointsBundle\Events\PointsEvent;

class PointsListener {

    protected $pm;

    public function __construct(PointsManager $pm)
    {
        $this->pm = $pm;
    }

    public function onSavePoints(PointsEvent $event)
    {
        $user = $event->getPoints()->getUser();
        $totalPoints = $this->pm->getPointsByUser($user);
        $this->pm->computePoints($totalPoints, $user);
    }
}