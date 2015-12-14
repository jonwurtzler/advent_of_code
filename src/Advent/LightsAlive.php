<?php

namespace Advent;

use Exception;
use SplFixedArray;

/**
 * My original intention was to calculate the light count and brightness at the same time.
 * That failed due to limitations of memory size in the number of arrays.
 *
 * THIS IS A VERY SLOW PROCESS
 *
 * @author Jon Wurtzler <jon.wurtzler@gmail.com>
 */
class LightsAlive extends AdventInstructions implements AdventOutputInterface
{
  /**
   * @var int
   */
  protected $height = 1000;

  /**
   * @var int
   */
  protected $lightBrightness = 0;

  /**
   * @var int
   */
  protected $lightCount = 0;

  /**
   * @var array
   */
  protected $lightMatrix;

  /**
   * @var int
   */
  protected $width  = 1000;

  public function __construct()
  {
    $this->resetMatrix();
  }

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $this->runLights($this->lightsAlive);
    $this->resetMatrix();
    $this->runLights($this->lightsAlive, true);

    echo ("Number of lights on: {$this->lightCount}\n");
    echo ("Level of brightness: {$this->lightBrightness}\n");
  }

  /**
   * Iterate through the array of commands.
   *
   * @param string[] $instructions
   * @param bool     $brightness
   *
   * @return void
   */
  public function runLights($instructions, $brightness = false)
  {
    $i = 1;
    foreach ($instructions as $instruction) {
      $this->parseInstruction($instruction, $brightness);

      /*
      if (!$brightness) {
        echo "running instruction: {$i}\n";
      } else {
        echo "running brightness instruction: {$i}\n";
      }
      */

      $i++;
    }
  }

  private function resetMatrix()
  {
    $h = array_fill(0, $this->height, 0);
    $this->lightMatrix = new SplFixedArray($this->width);

    foreach ($this->lightMatrix as $index => $value) {
      $this->lightMatrix->offsetSet($index, SplFixedArray::fromArray($h));
    }
  }

  /**
   * Parse the string into command and cords.
   *
   * @param string $instruction
   * @param bool   $brightness
   *
   * @return void
   * @throws Exception
   */
  private function parseInstruction($instruction, $brightness)
  {
    $instruction = strtolower(trim($instruction));

    $parts = explode(" through ", $instruction);
    $endCords = $this->parseCords(array_pop($parts));

    $parts = explode(" ", $parts[0]);
    $startCords = $this->parseCords(array_pop($parts));

    $command = $this->getMethodName($parts, $brightness);

    $this->runInstruction($command, $startCords, $endCords);
  }

  /**
   * Generate a method name from the command parts.
   *
   * @param string[] $parts
   * @param bool     $brightness
   *
   * @return string
   * @throws Exception
   */
  private function getMethodName($parts, $brightness)
  {
    if (count($parts) > 1) {
      $parts[1] = ucfirst($parts[1]);
    }

    $command = implode("", $parts);

    if (!$brightness) {
      $command .= "Light";
    } else {
      $command .= "Brightness";
    }

    if (!method_exists($this, $command)) {
      throw new Exception("Invalid command : $command");
    }

    return $command;
  }

  /**
   * Run through the cord list and run the corresponding command.
   *
   * @param string $command
   * @param int[]  $start
   * @param int[]  $end
   *
   * @return void
   * @throws Exception
   */
  private function runInstruction($command, $start, $end)
  {
    $xDiff = $end[0] - $start[0];
    $yDiff = $end[1] - $start[1];

    for ($i = 0; $i <= $xDiff; $i++) {
      for ($j = 0; $j <= $yDiff; $j++) {
        $this->$command(($start[0] + $i), ($start[1] + $j));
      }
    }
  }

  /**
   * Break string cords into int array for calculations.
   *
   * @param string $cords
   *
   * @return int[]
   */
  private function parseCords($cords)
  {
    return array_map("intval", explode(",", $cords));
  }

  /**
   * Remove cords from the lightsOn array if it does exist.
   *
   * @param int $x
   * @param int $y
   *
   * @return void
   */
  private function turnOffLight($x, $y)
  {
    if (1 === $this->lightMatrix[$x][$y]) {
      $this->lightMatrix[$x][$y] = 0;
      $this->lightCount--;
    }
  }

  /**
   * Remove a level of brightness.
   *
   * @param int $x
   * @param int $y
   *
   * @return void
   */
  private function turnOffBrightness($x, $y)
  {
    if (0 < $this->lightMatrix[$x][$y]) {
      $this->lightMatrix[$x][$y] -= 1;
      $this->lightBrightness--;
    }
  }

  /**
   * Add cords from the lightsOn array if it does not exist.
   *
   * @param int $x
   * @param int $y
   *
   * @return void
   */
  private function turnOnLight($x, $y)
  {
    if (0 === $this->lightMatrix[$x][$y]) {
      $this->lightMatrix[$x][$y] = 1;
      $this->lightCount++;
    }
  }

  /**
   * Add a level of brightness.
   *
   * @param int $x
   * @param int $y
   *
   * @return void
   */
  private function turnOnBrightness($x, $y)
  {
    $this->lightMatrix[$x][$y] += 1;
    $this->lightBrightness++;
  }

  /**
   * Add/Remove cords from the lightsOn array.
   *
   * @param int $x
   * @param int $y
   *
   * @return void
   */
  private function toggleLight($x, $y)
  {
    if (0 === $this->lightMatrix[$x][$y]) {
      $this->lightMatrix[$x][$y] = 1;
      $this->lightCount++;
    } else {
      $this->lightMatrix[$x][$y] = 0;
      $this->lightCount--;
    }
  }

  /**
   * Add two levels of brightness.
   *
   * @param int $x
   * @param int $y
   *
   * @return void
   */
  private function toggleBrightness($x, $y)
  {
    $this->lightMatrix[$x][$y] += 2;
    $this->lightBrightness     += 2;
  }

}
