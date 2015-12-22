<?php

namespace Advent;

use Exception;
use SplFixedArray;

class YardGif implements AdventOutputInterface
{

  /**
   * @var string
   */
  protected $fileInput = "src/data/yardGIF.txt";

  /**
   * @var SplFixedArray
   */
  protected $lightsEven;

  /**
   * @var SplFixedArray
   */
  protected $lightsOdd;

  /**
   * @var bool
   */
  protected $stuckLights = false;

  public function __construct()
  {
    $this->lightsEven = new SplFixedArray(100);
    $this->lightsOdd  = new SplFixedArray(100);
  }

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $this->loadInitialLights($this->fileInput);
    $lightsOnCount = $this->runLights();

    $this->stuckLights      = true;
    $this->loadInitialLights($this->fileInput);
    $lightsOnCountWithStuck = $this->runLights();

    echo ("Lights on after 100 animations: " . $lightsOnCount . "\n");
    echo ("Lights on after 100 animations (Stuck): " . $lightsOnCountWithStuck . "\n");
  }

  /**
   * Populate racers from the file provided.
   *
   * @param string $filePath
   *
   * @return void
   * @throws Exception
   */
  private function loadInitialLights($filePath) {
    $fh = fopen($filePath, 'r');

    if ($fh) {
      $i = 0;
      while (false !== ($line = fgets($fh, 4096))) {
        $column = new SplFixedArray(100);
        $this->lightsEven[$i] = $column->fromArray(str_split(rtrim($line, "\n")));;
        $this->lightsOdd[$i]  = $column->fromArray(str_split(rtrim($line, "\n")));;
        $i++;
      }
    } else {
      throw new Exception("Failed to load file: " . $filePath);
    }

    if ($this->stuckLights) {
      $this->setStuckLights($this->lightsEven);
      $this->setStuckLights($this->lightsOdd);
    }

    fclose($fh);
  }

  /**
   * Cycle the lights 100 times and see how many lights are still on.
   *
   * @return int
   */
  private function runLights()
  {
    for ($i = 1; $i <= 100; $i++) {
      if (($i % 2) == 0) {
       $this->animateLights($this->lightsEven, $this->lightsOdd);
      } else {
       $this->animateLights($this->lightsOdd, $this->lightsEven);
      }
    }

    return $this->countAllLights($this->lightsOdd);
  }

  /**
   * Run through the lights and determine the next step.
   *
   * @param SplFixedArray $starting
   * @param SplFixedArray $ending
   *
   * @return void
   */
  private function animateLights($starting, $ending) {
    for ($i = 0; $i < $starting->count(); $i++) {
      for ($j = 0; $j < $starting[$i]->count(); $j++) {
        $neighborOnCount = $this->countOnLights($starting, $i, $j);

        // On state currently
        if ($starting[$i][$j] === "#") {
          if ($neighborOnCount === 2 || $neighborOnCount === 3) {
            $ending[$i][$j] = "#";
          } else {
            $ending[$i][$j] = ".";
          }

        // Off state currently
        } else {
          if ($neighborOnCount === 3) {
            $ending[$i][$j] = "#";
          } else {
            $ending[$i][$j] = ".";
          }
        }
      }
    }

    if ($this->stuckLights) {
      $this->setStuckLights($ending);
    }
  }

  /**
   * Get a count of all lights currently on.
   *
   * @param SplFixedArray $lights
   *
   * @return int
   */
  private function countAllLights($lights)
  {
    $count = 0;

    for ($i = 0; $i < $lights->count(); $i++) {
      for ($j = 0; $j < $lights[$i]->count(); $j++) {
        if ($this->isLightOn($lights[$i][$j])) {
          $count++;
        }
      }
    }

    return $count;
  }

  /**
   * Check all 8 places around the current light.
   *
   * @param SplFixedArray $array
   * @param int           $row
   * @param int           $col
   *
   * @return int
   */
  private function countOnLights($array, $row, $col)
  {
    $count  = 0;
    $lights = [];

    $hasTopRow    = $row > 0;
    $hasBottomRow = $row < ($array->count() - 1);
    $hasLeftCol   = $col > 0;
    $hasRightCol  = $col < ($array[$row]->count() - 1);

    // Top Row
    if ($hasTopRow) {
      // Top Left
      if ($hasLeftCol) {
        $lights[] = $array[$row - 1][$col - 1];
      }

      // Top Center
      $lights[] = $array[$row - 1][$col];

      // Top Right
      if ($hasRightCol) {
        $lights[] = $array[$row - 1][$col + 1];
      }
    }

    // Center Left
    if ($hasLeftCol) {
      $lights[] = $array[$row][$col - 1];
    }

    // Center Right
    if ($hasRightCol) {
      $lights[] = $array[$row][$col + 1];
    }

    // Bottom Row
    if ($hasBottomRow) {
      // Bottom Left
      if ($hasLeftCol) {
        $lights[] = $array[$row + 1][$col - 1];
      }

      // Bottom Center
      $lights[] = $array[$row + 1][$col];

      // Bottom Right
      if ($hasRightCol) {
        $lights[] = $array[$row + 1][$col + 1];
      }
    }

    // Count how many lights are on
    if (count($lights) > 0) {
      foreach ($lights as $light) {
        if ($this->isLightOn($light)) {
          $count++;
        }
      }
    }

    return $count;
  }

  /**
   * Check if a light is 'on'
   *
   * @param string $light
   *
   * @return bool
   */
  private function isLightOn($light) {
    return $light === "#";
  }

  /**
   * Make sure all four corners are set to 'on'
   *
   * @param SplFixedArray $lights
   *
   * @return void
   */
  private function setStuckLights($lights)
  {
    $lastCol = ($lights[0]->count() - 1);
    $lastRow = ($lights->count() - 1);

    $lights[0][0]               = "#";
    $lights[0][$lastCol]        = "#";
    $lights[$lastRow][0]        = "#";
    $lights[$lastRow][$lastCol] = "#";
  }

}
