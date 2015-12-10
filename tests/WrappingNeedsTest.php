<?php

use Advent\WrappingNeeds;

class WrappingNeedsTest extends PHPUnit_Framework_TestCase
{

  // TC comes from the website examples. (TC = Test Case)
  public function testWrappingNeedsTC1()
  {
    $WrappingNeeds = new WrappingNeeds();
    $this->assertEquals(58, $WrappingNeeds->wrappingNeeded("2x3x4"));
  }

  public function testWrappingNeedsTC2()
  {
    $WrappingNeeds = new WrappingNeeds();
    $this->assertEquals(43, $WrappingNeeds->wrappingNeeded("1x1x10"));
  }

  public function testRibbonTC1()
  {
    $WrappingNeeds = new WrappingNeeds();
    $this->assertEquals(34, $WrappingNeeds->ribbonNeeded("2x3x4"));
  }

  public function testRibbonTC2()
  {
    $WrappingNeeds = new WrappingNeeds();
    $this->assertEquals(14, $WrappingNeeds->ribbonNeeded("1x1x10"));
  }

  /**
   * @expectedException Exception
   */
  public function testInvalidWrappingDimensions() {
    $WrappingNeeds = new WrappingNeeds();
    $WrappingNeeds->wrappingNeeded("23x4");
  }

  /**
   * @expectedException Exception
   */
  public function testInvalidRibbonDimensions() {
    $WrappingNeeds = new WrappingNeeds();
    $WrappingNeeds->ribbonNeeded("23x4");
  }
}
