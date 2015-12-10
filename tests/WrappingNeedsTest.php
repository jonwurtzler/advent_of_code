<?php

use Advent\WrappingNeeds;

class WrappingNeedsTest extends PHPUnit_Framework_TestCase
{

  // TC comes from the website examples. (TC = Test Case)
  public function testWrappingNeedsTC1()
  {
    $wrappingNeeds = new WrappingNeeds();
    $this->assertEquals(58, $wrappingNeeds->calculateTotalWrappingPaperArea(["2x3x4"]));
  }

  public function testWrappingNeedsTC2()
  {
    $wrappingNeeds = new WrappingNeeds();
    $this->assertEquals(43, $wrappingNeeds->calculateTotalWrappingPaperArea(["1x1x10"]));
  }

  /**
   * @expectedException Exception
   */
  public function testInvalidWrappingDimensions() {
    $wrappingNeeds = new WrappingNeeds();
    $wrappingNeeds->calculateTotalWrappingPaperArea(["23x4"]);
  }

  /* -----------------------------------------------------------------------------------------
   * Step 2
   */

  public function testRibbonTC1()
  {
    $wrappingNeeds = new WrappingNeeds();
    $this->assertEquals(34, $wrappingNeeds->calculateTotalRibbonArea(["2x3x4"]));
  }

  public function testRibbonTC2()
  {
    $wrappingNeeds = new WrappingNeeds();
    $this->assertEquals(14, $wrappingNeeds->calculateTotalRibbonArea(["1x1x10"]));
  }

  /**
   * @expectedException Exception
   */
  public function testInvalidRibbonDimensions() {
    $wrappingNeeds = new WrappingNeeds();
    $wrappingNeeds->calculateTotalRibbonArea(["23x4"]);
  }
}
