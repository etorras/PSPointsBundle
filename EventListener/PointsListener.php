<?php
/**
 * User: etorras
 * Date: 7/04/13
 */

namespace PS\Bundle\PSPointsBundle\EventListener;

use PS\Bundle\PSPointsBundle\Model\UserPointsManager;
use PS\Bundle\PSPointsBundle\Events\PointsEvent;

class PointsListener {

    protected $upm;
    protected $om;

    public function __construct ($om, UserPointsManager $upm)
    {
        $this->upm = $upm;
        $this->om = $om;
    }

    public function onSavePoints(PointsEvent $event)
    {
        $user = $event->getPoints()->getUser();
        $totalPoints = $this->om->getRepository('PSPSPointsBundle:Points')->findTotalPointsByUser($user);
        $params = array (
            'user' => $user,
            'points' => $totalPoints
        );
        $userPoints = $this->om->getRepository('PSPSPointsBundle:UserPoints')->find($user);
        if (null == $userPoints) {
            $this->upm->create($params);
        }
        else {
            $this->upm->update($params, $userPoints);
        }
    }
}