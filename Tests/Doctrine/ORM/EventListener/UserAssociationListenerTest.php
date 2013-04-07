<?php
/**
 * Created by JetBrains PhpStorm.
 * User: etorras
 * Date: 8/04/13
 * Time: 0:03
 * To change this template use File | Settings | File Templates.
 */

namespace PS\Bundle\PSPointsBundle\Tests\Doctrine\ORM\EventListener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use PS\Bundle\PSPointsBundle\Doctrine\ORM\EventListener\UserAssociationListener;

class UserAssociationListenerTest extends \PHPUnit_Framework_TestCase {
    protected $entityManager;
    protected $metadataPoints;
    protected $metadataUserPoints;

    public function setUp()
    {
        $this->entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->metadataPoints = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
            ->disableOriginalConstructor()
            ->getMock();

        $this->metadataPoints->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('PS\Bundle\PSPointsBundle\Entity\Points'));

        $this->metadataUserPoints = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
            ->disableOriginalConstructor()
            ->getMock();

        $this->metadataUserPoints->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('PS\Bundle\PSPointsBundle\Entity\UserPoints'));

    }

    public function testLoadClassMetadataPoints()
    {
        $event = new LoadClassMetadataEventArgs($this->metadataPoints  , $this->entityManager);

        $listener = new UserAssociationListener('UserClass');

        $this->metadataPoints->expects($this->once())
            ->method('mapManyToOne');

        $listener->loadClassMetadata($event);
    }

    public function testLoadClassMetadataUserPoints()
    {

        $event = new LoadClassMetadataEventArgs($this->metadataUserPoints, $this->entityManager);

        $listener = new UserAssociationListener('UserClass');

        $this->metadataUserPoints->expects($this->once())
            ->method('mapOneToOne');

        $listener->loadClassMetadata($event);
    }
}
