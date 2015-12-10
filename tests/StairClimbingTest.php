<?php

use Advent\StairClimber;

class StairClimbingTest extends PHPUnit_Framework_TestCase
{
  public function testUp()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(1, $stairClimber->finalFloor("("));
  }

  public function testDown()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(-1, $stairClimber->finalFloor(")"));
  }

  public function testMainFloor()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(0, $stairClimber->finalFloor(")("));
  }

  // Test example from the website
  public function testTC1()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(0, $stairClimber->finalFloor("()()"));
  }

  // Test example from the website
  public function testTC2()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(3, $stairClimber->finalFloor("(()(()("));
  }

  // Test example from the website
  public function testTC3()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(3, $stairClimber->finalFloor("))((((("));
  }

  // Test example from the website
  public function testTC4()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(-1, $stairClimber->finalFloor("))("));
  }

  // Test example from the website
  public function testTC5()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(-3, $stairClimber->finalFloor(")())())"));
  }

  public function testBasementOne()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(1, $stairClimber->stepsToBasement(")"));
  }

  public function testBasementMany()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(5, $stairClimber->stepsToBasement("(()))"));
  }
}
