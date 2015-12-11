<?php

use Advent\NaughtyNiceList;

class NaughtyNiceListTest extends PHPUnit_Framework_TestCase
{
  // TC comes from the website examples. (TC = Test Case)
  public function testTC1()
  {
    $naughtyNiceList = new NaughtyNiceList();
    $this->assertEquals(1, $naughtyNiceList->checkList(["ugknbfddgicrmopn"]));
  }

  public function testTC2()
  {
    $naughtyNiceList = new NaughtyNiceList();
    $this->assertEquals(1, $naughtyNiceList->checkList(["aaa"]));
  }

  public function testTC3()
  {
    $naughtyNiceList = new NaughtyNiceList();
    $this->assertEquals(0, $naughtyNiceList->checkList(["jchzalrnumimnmhp"]));
  }

  public function testTC4()
  {
    $naughtyNiceList = new NaughtyNiceList();
    $this->assertEquals(0, $naughtyNiceList->checkList(["haegwjzuvuyypxyu"]));
  }

  public function testTC5()
  {
    $naughtyNiceList = new NaughtyNiceList();
    $this->assertEquals(0, $naughtyNiceList->checkList(["dvszwmarrgswjxmb"]));
  }

  /* -----------------------------------------------------------------------------------------
   * Step 2
   */

  public function testAdvancedTC1()
  {
    $naughtyNiceList = new NaughtyNiceList();
    $this->assertEquals(1, $naughtyNiceList->checkList(["qjhvhtzxzqqjkmpb"], true));
  }

  public function testAdvancedTC2()
  {
    $naughtyNiceList = new NaughtyNiceList();
    $this->assertEquals(1, $naughtyNiceList->checkList(["xxyxx"], true));
  }

  public function testAdvancedTC3()
  {
    $naughtyNiceList = new NaughtyNiceList();
    $this->assertEquals(0, $naughtyNiceList->checkList(["uurcxstgmygtbstg"], true));
  }

  public function testAdvancedTC4()
  {
    $naughtyNiceList = new NaughtyNiceList();
    $this->assertEquals(0, $naughtyNiceList->checkList(["ieodomkazucvgmuy"], true));
  }

}
