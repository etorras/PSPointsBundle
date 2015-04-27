<?php
/**
     *
     */
namespace PS\Bundle\PSPointsBundle\Doctrine\ORM\EventListener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

/**
 * Doctrine ORM Listener updating the Answer entity to set a one to one
 * relationship with the user class defined in configuration
 */
class UserAssociationListener
{
    protected $userClassname;

    /**
     * @param $userClassname
     * @internal param string $user_class
     */
    public function __construct($userClassname)
    {
        $this->userClassname = $userClassname;
    }

    /**
     * @param \Doctrine\ORM\Event\LoadClassMetadataEventArgs $args
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        $classMetadata = $args->getClassMetadata();

        if ($classMetadata->getName() == 'PS\Bundle\PSPointsBundle\Entity\Points') {
            //Setting the Many to one relationship
            $builder = new ClassMetadataBuilder($args->getClassMetadata());
            $builder->addManyToOne('user', $this->userClassname, 'points');
        } elseif ($classMetadata->getName() == 'PS\Bundle\PSPointsBundle\Entity\UserPoints') {
            //Setting the one to one relationship
            $builder = new ClassMetadataBuilder($args->getClassMetadata());
            $builder->addOwningOneToOne('user', $this->userClassname);

        } elseif ($classMetadata->getName() == substr($this->userClassname, 1)) {
            //Setting the Many to one relationship
            $builder = new ClassMetadataBuilder($args->getClassMetadata());
            $builder->addOneToMany('points', 'PS\Bundle\PSPointsBundle\Entity\Points', 'user');

            //$builder = new ClassMetadataBuilder($args->getClassMetadata());
            //$builder->addOneToMany('points', 'PS\Bundle\PSPointsBundle\Entity\UserPoints', 'user');
        }
    }
}