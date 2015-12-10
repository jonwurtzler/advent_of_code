<?php

namespace Advent;

use Exception;

class SantaDeliveries extends AdventInstructions implements AdventOutputInterface
{

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $santaVisits         = $this->santaDirections($this->santaDeliveries);
    $santaAndRobotVisits = $this->santaAndRobotDirections($this->santaDeliveries);

    echo ("Santa alone visted: {$santaVisits} homes\n");
    echo ("Santa and the robot visited: {$santaAndRobotVisits} homes\n");
  }

  /**
   * Record number of homes Santa visited himself.
   *
   * @param string $directions
   *
   * @return int
   */
  function santaDirections($directions)
  {
    $cords = [0, 0];
    $visited = ["0,0"];

    for ($i = 0; $i < strlen($directions); $i++) {
      $cords = $this->followDirections($directions[$i], $cords);

      $cordLabel = $cords[0] . "," . $cords[1];

      if (!in_array($cordLabel, $visited)) {
        $visited[] = $cordLabel;
      }
    }

    return count($visited);
  }

  /**
   * Record the number of homes Santa AND his Robot visit.
   *
   * @param string $directions
   *
   * @return array
   */
  function santaAndRobotDirections($directions)
  {
    $santaCords = [0, 0];
    $robotCords = [0, 0];
    $turn       = 0;
    $visited    = ["0,0"];

    for ($i = 0; $i < strlen($directions); $i++) {
      if ($turn % 2 > 0) {
        $santaCords = $this->followDirections($directions[$i], $santaCords);
        $cordLabel = $santaCords[0] . "," . $santaCords[1];
      } else {
        $robotCords = $this->followDirections($directions[$i], $robotCords);
        $cordLabel = $robotCords[0] . "," . $robotCords[1];
      }

      if (!in_array($cordLabel, $visited)) {
        $visited[] = $cordLabel;
      }

      $turn++;
    }

    return count($visited);
  }

  /**
   * Record the movement.
   *
   * @param string $direction
   * @param array  $cords
   *
   * @return array
   * @throws Exception
   */
  public function followDirections($direction, $cords)
  {
    switch ($direction) {
      case "<":
        $cords[0]--;
        break;
      case ">":
        $cords[0]++;
        break;
      case "^":
        $cords[1]++;
        break;
      case "v":
        $cords[1]--;
        break;
      default:
        throw new Exception("Invalid Direction: {$direction}");
    }

    return $cords;
  }

}
