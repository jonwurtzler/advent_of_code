<?php

use Advent\WrappingNeeds;

class WrappingNeedsTest extends PHPUnit_Framework_TestCase
{

  // TC comes from the website examples. (TC = Test Case)
  public function testWrappingNeedsTC1()
  {
    $wrappingNeeds = new WrappingNeeds();
    $this->assertEquals(58, $wrappingNeeds->wrappingNeeded("2x3x4"));
  }

  public function testWrappingNeedsTC2()
  {
    $wrappingNeeds = new WrappingNeeds();
    $this->assertEquals(43, $wrappingNeeds->wrappingNeeded("1x1x10"));
  }

  public function testRibbonTC1()
  {
    $wrappingNeeds = new WrappingNeeds();
    $this->assertEquals(34, $wrappingNeeds->ribbonNeeded("2x3x4"));
  }

  public function testRibbonTC2()
  {
    $wrappingNeeds = new WrappingNeeds();
    $this->assertEquals(14, $wrappingNeeds->ribbonNeeded("1x1x10"));
  }

  /**
   * @expectedException Exception
   */
  public function testInvalidWrappingDimensions() {
    $wrappingNeeds = new WrappingNeeds();
    $wrappingNeeds->wrappingNeeded("23x4");
  }

  /**
   * @expectedException Exception
   */
  public function testInvalidRibbonDimensions() {
    $wrappingNeeds = new WrappingNeeds();
    $wrappingNeeds->ribbonNeeded("23x4");
  }
}
