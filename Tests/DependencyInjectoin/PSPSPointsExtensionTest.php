<?php
/**
     * User: etorras
     * Date: 7/04/13
     */

namespace PS\Bundle\PSPointsBundle\Tests\DependencyInyection;

use PS\Bundle\PSPointsBundle\DependencyInjection\PSPSPointsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

class PSPSPointsExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $configuration;

    public function setUp()
    {
        $this->configuration = New ContainerBuilder();
    }

    public function testThrowsExceptionUnlessUserClassSet()
    {
        $this->setExpectedException('\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException');
        $loader = new PSPSPointsExtension();
        $config = $this->getBasicConfig();
        unset($config['user_class']);
        $loader->load(array($config), $this->configuration);
    }

    public function testThrowsExceptionIfUnknownParameterSet()
    {
        $this->setExpectedException('\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException');
        $loader = new PSPSPointsExtension();
        $config = $this->getBasicConfig();
        $config['unknown'] = 'test';
        $loader->load(array($config), $this->configuration);
    }

    public function testThrowsExceptionIfUnknownInheritanceSet()
    {
        $this->setExpectedException('\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException');
        $loader = new PSPSPointsExtension();
        $config = $this->getBasicConfig();
        $config['parameter']['level1']['level2'] = 1;
        $loader->load(array($config), new ContainerBuilder());
    }

    public function testThrowsExceptionIfNotIntergerValue()
    {
        $this->setExpectedException('\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException');
        $loader = new PSPSPointsExtension();
        $config = $this->getBasicConfig();
        $config['parameters']['level2']='test';
        $loader->load(array($config), new ContainerBuilder());

    }

    public function testListenerEnabledUserAssociation()
    {
        $loader = new PSPSPointsExtension();
        $config = $this->getBasicConfig();
        $loader->load(array($config), $this->configuration);

        $def = $this->configuration->getDefinition('psps.user_asocciation.listener');

        $this->assertTrue($def->hasTag('doctrine.event_listener'));

    }

    public function testListenerEnabledComputePoints()
    {
        $loader = new PSPSPointsExtension();
        $config = $this->getBasicConfig();
        $loader->load(array($config), $this->configuration);

        $def = $this->configuration->getDefinition('psps.user_add_points.listener');

        $this->assertTrue($def->hasTag('kernel.event_listener'));

    }

    protected function getBasicConfig()
    {
        $yaml = <<<EOF
user_class: Acme\DemoBundle\Document\User
parameters:
    level1: 1
    level2: 2
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}