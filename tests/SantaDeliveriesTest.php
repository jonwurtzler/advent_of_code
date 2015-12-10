<?php

use Advent\SantaDeliveries;

class SantaDeliveriesTest extends PHPUnit_Framework_TestCase
{
  // TC comes from the website examples. (TC = Test Case)
  public function testSantaDeliveriesTC1()
  {
    $santaDeliveries = new SantaDeliveries();
    $this->assertEquals(2, $santaDeliveries->santaDirections(">"));
  }

  public function testSantaDeliveriesTC2()
  {
    $santaDeliveries = new SantaDeliveries();
    $this->assertEquals(4, $santaDeliveries->santaDirections("^>v<"));
  }

  public function testSantaDeliveriesTC3()
  {
    $santaDeliveries = new SantaDeliveries();
    $this->assertEquals(2, $santaDeliveries->santaDirections("^v^v^v^v^v"));
  }

  /**
   * @expectedException Exception
   */
  public function testInvalidSantaDirection() {
    $santaDeliveries = new SantaDeliveries();
    $santaDeliveries->santaDirections("^>a");
  }

  /* -----------------------------------------------------------------------------------------
   * Step 2
   */

  public function testSantaAndRobotDeliveriesTC1()
  {
    $santaDeliveries = new SantaDeliveries();
    $this->assertEquals(3, $santaDeliveries->santaAndRobotDirections("^v"));
  }

  public function testSantaAndRobotDeliveriesTC2()
  {
    $santaDeliveries = new SantaDeliveries();
    $this->assertEquals(3, $santaDeliveries->santaAndRobotDirections("^>v<"));
  }

  public function testSantaAndRobotDeliveriesTC3()
  {
    $santaDeliveries = new SantaDeliveries();
    $this->assertEquals(11, $santaDeliveries->santaAndRobotDirections("^v^v^v^v^v"));
  }

  /**
   * @expectedException Exception
   */
  public function testInvalidSantaAndRobotDirection() {
    $santaDeliveries = new SantaDeliveries();
    $santaDeliveries->santaDirections("^>a");
  }
}
