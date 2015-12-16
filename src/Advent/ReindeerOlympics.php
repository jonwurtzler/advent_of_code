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

  /**
   * Populate racers from the file provided.
   *
   * @param string $filePath
   *
   * @return void
   * @throws Exception
   */
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

    fclose($fh);
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
      $leaderNames = $this->getLeaderNames($i);

      foreach ($leaderNames as $name) {
        if (!isset($results[$name]['points'])) {
          $results[$name]['points'] = 0;
        }

        $results[$name]['points']++;
      }
    }

    $results = $this->sortPointRaceResults($results);

    foreach ($results as $racerName => $data) {
      $output .= $racerName . " made " . $data['points'] . " points\n";
    }

    return $output;
  }

  /**
   * Get the name(s) of the leader(s) at the given time interval.
   *
   * @param int $time
   *
   * @return string[]
   */
  private function getLeaderNames($time)
  {
    $leaderDistance = 0;
    $leaderNames    = [];

    foreach ($this->racers as $racerName => $racer) {
      $results[$racerName]['distance'] = $racer->distanceTraveled($time);

      if ($results[$racerName]['distance'] > $leaderDistance) {
        $leaderNames    = [$racerName];
        $leaderDistance = $results[$racerName]['distance'];
      } elseif ($leaderDistance === $results[$racerName]['distance']) {
        $leaderNames[] = $racerName;
      }
    }

    return $leaderNames;
  }

  /**
   * Sort the results of the point race by points.
   *
   * @param array $results
   *
   * @return array
   */
  private function sortPointRaceResults($results)
  {
    foreach ($results as $name => $value) {
      $points[$name] = $value['points'];
    }

    array_multisort($points, SORT_DESC, $results);

    return $results;
  }

}
