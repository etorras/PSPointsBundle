<?php
/**.
 * User: etorras
 * Date: 31/03/13
 * Time: 17:07
 */

namespace PS\Bundle\PSPointsBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Points manager.
 * Access point to all the bundle's features and factory service to create database objects
 */
class PointsManager
{

    /**
     * ObjectManager to access the database, by ORM or ODM
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
     * Save the answers to an enquiry to the database.
     * The enquiry can be specified by its database object representation or by name
     * The responses come in an array of Response objects
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $user   The user that the answers belongs to.
     */
    public function savePoints($points, UserInterface $user = null)
    {
        echo "Guardando " . $points . " puntos";
    }

}