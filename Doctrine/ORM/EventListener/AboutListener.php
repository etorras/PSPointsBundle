<?php
/**
 * Created by JetBrains PhpStorm.
 * User: etorras
 */

namespace PS\Bundle\PSPointsBundle\Doctrine\ORM\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

class AboutListener
{
    public function prePersist(LifecycleEventArgs $event)
    {
        if ($event->getEntity() instanceof \PS\Bundle\PSPointsBundle\Entity\Points) {
            $points = $event->getEntity();
            $about = $points->getAbout();

            $metadata = $event->getEntityManager()->getClassMetadata(get_class($about));

            $definition = json_encode(array("className"=>$metadata->getName(), "ids"=>$metadata->getIdentifierValues($about)));

            $points->setAbout($definition);
        }
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        if ($event->getEntity() instanceof \PS\Bundle\PSPointsBundle\Entity\Points) {
            $event->setNewValue('about', $event->getOldValue('about'));
        }

    }

    public function postLoad(LifecycleEventArgs $event)
    {
        $this->regenerateAboutField($event);
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $this->regenerateAboutField($event);
    }

    protected function regenerateAboutField(LifecycleEventArgs $event)
    {
        if ($event->getEntity() instanceof \PS\Bundle\PSPointsBundle\Entity\Points) {
            $points = $event->getEntity();
            $definition = $points->getAbout();

            $object = json_decode($definition, true);

            $className = $object['className'];
            $ids = $object['ids'];

            $about = $event->getEntityManager()->getReference($className, $ids);

            $points->setAbout($about);
        }
    }
}