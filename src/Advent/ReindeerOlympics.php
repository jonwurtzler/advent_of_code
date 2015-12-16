<?php

namespace Advent;

use Advent\Reindeer\Reindeer;
use Advent\Reindeer\ReindeerFactory;
use Exception;

class ReindeerOlympics implements AdventOutputInterface
{
  /**
   * @var string
   */
  protected $fileInput = "src/data/reindeer.txt";

  /**
   * @var int
   */
  protected $raceDuration = 2503;

  /**
   * @var Reindeer[]
   */
  protected $racers = [];

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $this->loadReindeer($this->fileInput);
    $distanceResults = $this->distanceRace();
    $pointsResults   = $this->pointsRace();

    echo ("Distance Race: \n" . $distanceResults . "\n");
    echo ("Points Race: \n" . $pointsResults . "\n");
  }

  private function loadReindeer($filePath) {
    $fh = fopen($filePath, 'r');

    if ($fh) {
      $reindeerFactory = new ReindeerFactory();

      while (false !== ($line = fgets($fh, 4096))) {
        $reindeer = $reindeerFactory->createReindeer($line);
        $this->racers[$reindeer->getName()] = $reindeer;
      }
    } else {
      throw new Exception("Failed to load file: " . $filePath);
    }
  }

  /**
   * Run the race via points instead of just distance.
   *
   * @return string
   */
  private function pointsRace()
  {
    $results = [];
    $output  = "";

    for ($i = 1; $i <= $this->raceDuration; $i++) {
      $currWinnerName  = "";
      $currWinnerStats = [];

      foreach ($this->racers as $racerName => $racer) {
        $results[$racerName]['distance'] = $racer->distanceTraveled($i);
        if (1 === $i) {
          $results[$racerName]['points'] = 0;
        }

        if (empty($currWinnerName)) {
          $currWinnerName = $racerName;
          $currWinnerStats = $results[$racerName];
        } elseif ($currWinnerStats['distance'] < $results[$racerName]['distance'])
      }

      $results[0]['points']++;
    }

    array_multisort($results['points'], SORT_DESC, SORT_NUMERIC);
    foreach ($results as $racerName => $data) {
      $output .= $racerName . " made " . $data['points'] . "points\n";
    }

    return $output;
  }

  /**
   * Run the race via distance.
   *
   * @return string
   */
  private function distanceRace() {
    $results = [];
    $output  = "";

    foreach ($this->racers as $racerName => $racer) {
      $results[$racerName] = $racer->distanceTraveled($this->raceDuration);
    }

    arsort($results);
    foreach ($results as $racerName => $distance) {
      $output .= $racerName . " made it " . $distance . "km\n";
    }

    return $output;
  }

}
