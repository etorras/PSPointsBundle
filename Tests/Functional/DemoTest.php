<?php

namespace PS\Bundle\PSPointsBundle\Tests\DependencyInyection;

class DemoTest extends \PHPUnit_Framework_TestCase
{
      /**
       * @var \RemoteWebDriver
       */
      protected $webDriver;

      public function setUp()
      {
          $capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'chrome');
          $this->webDriver = \RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
      }

      protected $url = 'https://parclick.com';

      public function testParclick()
      {
          $this->webDriver->get($this->url);
          // checking that page title contains word 'GitHub'
          $this->assertContains('Parclick', $this->webDriver->getTitle());
      }

      public function tearDown()
      {
          //$this->webDriver->close();
          $this->webDriver->quit(); // es la buena
      }
  }
