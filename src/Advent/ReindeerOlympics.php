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
    $results = $this->race();

    echo ("Race 1: \n" . $results . "\n");
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

  private function race() {
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