<?php

namespace PS\Bundle\PSPointsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

use PS\Bundle\PSPointsBundle\Model\PointsManager;

class PointsController
{
    // Points Manager
    protected $pm;

    // Security Context
    protected $sc;

    /**
     * Constructor
     *
     * @param PS\Bundle\PSPointsBundle\Model\PointsManager $pm
     */
    public function __construct(PointsManager $pm, SecurityContextInterface $sc)
    {
        $this->pm = $pm;
        $this->sc = $sc;
    }

    public function savePointsAction($points, Request $request)
    {
        $user = $this->getUser();
        var_dump($user);
        $this->pm->savePoints($points,$user);

    }

    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @see Symfony\Component\Security\Core\Authentication\Token\TokenInterface::getUser()
     */
    public function getUser()
    {

        if (null === $token = $this->sc->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }

}
