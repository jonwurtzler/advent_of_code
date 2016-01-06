<?php

namespace Advent;

use Advent\SleighBalance\SleighLayout;
use Exception;

// Max Weight per area = 516
// 290263857203 to high
// 258360887003 to high (I think)
// 239319593291 nope
// 237855034643 (31, 61, 101, 103, 107, 113)
// 223030114451 (31, 53, 103, 107, 109, 113)

class SleighBalance implements AdventOutputInterface
{

  /**
   * @var SleighLayout
   */
  protected $bestSleigh = null;

  /**
   * @var string
   */
  protected $fileInput = "src/data/giftWeights.txt";

  /**
   * @var array
   */
  protected $giftWeights = [];

  /**
   * @var array
   */
  protected $loads = [];

  /**
   * @var int
   */
  protected $maxPassengerGifts = 6;

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $this->loadGiftWeights($this->fileInput);
    $sleigh = new SleighLayout();
    $sleigh->setMaxAreaWeight($this->giftWeights);

    $this->loadSleigh($sleigh, $this->giftWeights);

    sort($this->loads);

    foreach ($this->loads as $giftNumber => $quantum) {
      echo("Passenger Gift Count: " . $giftNumber . " (QE = " . $quantum . ")\n");
    }

  }

  /**
   * Populate elements from the file provided.
   *
   * @param string $filePath
   *
   * @return void
   * @throws Exception
   */
  private function loadGiftWeights($filePath) {
    $fh = fopen($filePath, 'r');

    if ($fh) {
      while (false !== ($line = fgets($fh, 4096))) {
        $this->giftWeights[] = rtrim($line, "\n");
      }
    } else {
      throw new Exception("Failed to load file: " . $filePath);
    }

    fclose($fh);
  }

  /**
   * Load a sleigh with gifts.
   *   Recursive.
   *
   * @param SleighLayout  $sleigh
   * @param int[]         $giftWeights
   *
   * @return void
   */
  private function loadSleigh($sleigh, $giftWeights)
  {
    $gift = array_shift($giftWeights);

    foreach ($sleigh->getSleighAreas() as $area) {
      $clonedSleigh = clone $sleigh;

      if (!$clonedSleigh->loadGift($area, $gift)) {
        continue;
      }

      if (
        ($area === "passenger")
        && ($clonedSleigh->getAreaGiftCount() > $this->maxPassengerGifts)
      ) {
        continue;
      }

      if (count($giftWeights) > 0) {
        $this->loadSleigh($clonedSleigh, $giftWeights);
      } else {
        // Record successful equal weight load.
        $this->recordSleighLayout($clonedSleigh);
      }
    }
  }

  /**
   * Successfully loaded each area with the same weight.
   *
   * @param SleighLayout $sleigh
   *
   * @return void
   */
  private function recordSleighLayout($sleigh)
  {
    $passengerCount      = $sleigh->getAreaGiftCount();
    $quantumEntanglement = $sleigh->getAreaQuantumEntanglement();

    if (!isset($this->loads[$passengerCount])) {
      $this->bestSleigh = $sleigh;
      $this->loads[$passengerCount] = $quantumEntanglement;
    } else {
      if ($this->loads[$passengerCount] > $quantumEntanglement) {
        $this->bestSleigh = $sleigh;
        $this->loads[$passengerCount] = $quantumEntanglement;
      }
    }
  }

}
