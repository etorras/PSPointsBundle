<?php
/**
 * Created by JetBrains PhpStorm.
 * User: etorras
 * Date: 6/04/13
 * Time: 1:36
 * To change this template use File | Settings | File Templates.
 */

namespace PS\Bundle\PSPointsBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

abstract class Points {
    /**
     * @var integer
     */
    protected  $id;

    /**
     * @var \DateTime
     */
    protected $creationDate;

    /**
     * @var \Symfony\Component\Security\Core\User\UserInterface
     */
    protected $user;

    /**
     * @var string
     */
    protected $source;

    /**
     * @var integer
     */
    protected $points;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Points
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
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
     * Set source
     *
     * @param string $source
     * @return Points
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
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