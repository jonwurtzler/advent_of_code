<?php
use Advent\StairClimber;

/**
 * @author Jon Wurtzler <jon.wurtzler@gmail.com>
 */
class AdventTests extends PHPUnit_Framework_TestCase
{
  public function testStairClimberUp()
  {
      $stairClimber = new StairClimber();
      $this->assertEquals(1, $stairClimber->finalFloor("("));
  }

  public function testStairClimberDown()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(-1, $stairClimber->finalFloor(")"));
  }

  public function testStairClimberMainFloor()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(0, $stairClimber->finalFloor(")("));
  }

  // Test example from the website
  public function testStairClimberTC1()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(0, $stairClimber->finalFloor("()()"));
  }

  // Test example from the website
  public function testStairClimberTC2()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(3, $stairClimber->finalFloor("(()(()("));
  }

  // Test example from the website
  public function testStairClimberTC3()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(3, $stairClimber->finalFloor("))((((("));
  }

  // Test example from the website
  public function testStairClimberTC4()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(-1, $stairClimber->finalFloor("))("));
  }

  // Test example from the website
  public function testStairClimberTC5()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(-3, $stairClimber->finalFloor(")())())"));
  }

  public function testStairClimberBasementOne()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(1, $stairClimber->stepsToBasement(")"));
  }

  public function testStairClimberBasementMany()
  {
    $stairClimber = new StairClimber();
    $this->assertEquals(5, $stairClimber->stepsToBasement("(()))"));
  }

}
