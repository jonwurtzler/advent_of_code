<?php

namespace Advent;

class StairClimber extends AdventInstructions implements AdventOutputInterface
{

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $finalFloor  = $this->finalFloor($this->climbingDirections);
    $stepsToBase = $this->stepsToBasement($this->climbingDirections);

    echo ("Santa ended on floor: {$finalFloor}\n");
    echo ("Santa first went to the basement at step: {$stepsToBase}\n");
  }

  /**
   * Determine what floor Santa will be on after the instructions given.
   *
   * @return int
   */
  public function finalFloor($instructions)
  {
    $floor = 0;

    for ($i = 0; $i < strlen($instructions); $i++) {
      if ("(" === $instructions[$i]) {
        $floor++;
      } else {
        $floor--;
      }
    }

    return $floor;
  }

  /**
   * Determine the number of steps Santa has to make before he first goes into the basement.
   *
   * @return int
   */
  public function stepsToBasement($instructions)
  {
    $floor = 0;

    for ($i = 0; $i < strlen($instructions); $i++) {
      if ("(" === $instructions[$i]) {
        $floor++;
      } else {
        $floor--;
      }

      if ($floor < 0) {
        return $i + 1;
      }
    }

    return $floor;
  }

}
