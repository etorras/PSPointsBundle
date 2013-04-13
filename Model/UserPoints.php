<?php
/**
 * User: etorras
 * Date: 7/04/13
 */

namespace PS\Bundle\PSPointsBundle\Model;


abstract class UserPoints {
    /**
     * @var integer
     */
    protected  $id;

    /**
     * @var \DateTime
     */
    protected $lastUpdate;

    /**
     * @var \Symfony\Component\Security\Core\User\UserInterface
     */
    protected $user;

    /**
     * @var integer
     */
    protected $points;

    /**
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @param \DateTime $lastUpdate
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * Set user
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return Points
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return Points
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }
}