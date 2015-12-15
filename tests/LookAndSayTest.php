<?php

use Advent\LookAndSay;

class LookAndSayTest extends \PHPUnit_Framework_TestCase
{

  // TC comes from the website examples. (TC = Test Case)
  public function testTC1()
  {
    $lookAndSay = new LookAndSay();
    $this->assertEquals(2, $lookAndSay->lookAndSay("1", 1));
  }

  public function testTC2()
  {
    $lookAndSay = new LookAndSay();
    $this->assertEquals(2, $lookAndSay->lookAndSay("11", 1));
  }

  public function testTC3()
  {
    $lookAndSay = new LookAndSay();
    $this->assertEquals(4, $lookAndSay->lookAndSay("21", 1));
  }

  public function testTC4()
  {
    $lookAndSay = new LookAndSay();
    $this->assertEquals(6, $lookAndSay->lookAndSay("1211", 1));
  }

  /**
   * @expectedException Exception
   */
  public function testNonNumberString() {
    $lookAndSay = new LookAndSay();
    $lookAndSay->lookAndSay("121a", 1);
  }
}
