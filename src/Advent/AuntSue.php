<?php

namespace Advent;

use Advent\Aunt\Aunt;
use Advent\Aunt\AuntFactory;
use Exception;

class AuntSue implements AdventOutputInterface
{

  /**
   * @var Aunt[]
   */
  protected $aunts = [];

  /**
   * @var bool
   */
  protected $fuzzyCalibration = false;

  /**
   * @var string
   */
  protected $fileInput = "src/data/sues.txt";

  /**
   * @var array
   */
  protected $tickertape = [
    'children'    => 3,
    'cats'        => 7,
    'samoyeds'    => 2,
    'pomeranians' => 3,
    'akitas'      => 0,
    'vizslas'     => 0,
    'goldfish'    => 5,
    'trees'       => 3,
    'cars'        => 2,
    'perfumes'    => 1
  ];

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $this->loadAunts($this->fileInput);

    $auntName = $this->findAunt($this->tickertape);
    $this->fuzzyCalibration = true;
    $realAuntName = $this->findAunt($this->tickertape);

    echo ("Aunt Found: " . $auntName . "\n");
    echo ("Real Aunt Found: " . $realAuntName . "\n");
  }

  /**
   * Populate aunts from the file provided.
   *
   * @param string $filePath
   *
   * @return void
   * @throws Exception
   */
  private function loadAunts($filePath) {
    $fh = fopen($filePath, 'r');

    if ($fh) {
      $auntFactory = new AuntFactory();

      while (false !== ($line = fgets($fh, 4096))) {
        $aunt = $auntFactory->createAunt($line);
        $this->aunts[$aunt->getName()] = $aunt;
      }
    } else {
      throw new Exception("Failed to load file: " . $filePath);
    }
  }

  /**
   * Go through and find which aunt has most in common with the tickertape.
   *
   * @param array $tape
   *
   * @return string
   */
  private function findAunt($tape)
  {
    $analysis = [];

    foreach ($this->aunts as $aunt) {
      $matchCount = 0;
      foreach ($tape as $category => $value) {
        $compare = "compare" . ucfirst($category);

        if ($this->$compare($aunt, $value)) {
          $matchCount++;
        }
      }

      $analysis[$aunt->getName()] = $matchCount;
    }

    arsort($analysis);
    reset($analysis);

    return key($analysis);
  }

  /**
   * @param Aunt $aunt
   * @param int  $tickerValue
   *
   * @return bool
   */
  private function compareAkitas($aunt, $tickerValue)
  {
    if (
      !is_null($auntValue = $aunt->getAkitas())
      && ($auntValue === $tickerValue)
    ) {
      return true;
    }

    return false;
  }
  /**
   * @param Aunt $aunt
   * @param int  $tickerValue
   *
   * @return bool
   */
  private function compareChildren($aunt, $tickerValue)
  {
    if (
      !is_null($auntValue = $aunt->getChildren())
      && ($auntValue === $tickerValue)
    ) {
      return true;
    }

    return false;
  }

  /**
   * @param Aunt $aunt
   * @param int  $tickerValue
   *
   * @return bool
   */
  private function compareCars($aunt, $tickerValue)
  {
    if (
      !is_null($auntValue = $aunt->getCars())
      && ($auntValue === $tickerValue)
    ) {
      return true;
    }

    return false;
  }

  /**
   * @param Aunt $aunt
   * @param int  $tickerValue
   *
   * @return bool
   */
  private function compareCats($aunt, $tickerValue)
  {
    if (!is_null($auntValue = $aunt->getCats())) {
      if (!$this->fuzzyCalibration && ($auntValue === $tickerValue)) {
        return true;
      }

      if ($this->fuzzyCalibration && ($auntValue > $tickerValue)) {
        return true;
      }
    }

    return false;
  }

  /**
   * @param Aunt $aunt
   * @param int  $tickerValue
   *
   * @return bool
   */
  private function compareGoldfish($aunt, $tickerValue)
  {
    if (!is_null($auntValue = $aunt->getGoldfish())) {
      if (!$this->fuzzyCalibration && ($auntValue === $tickerValue)) {
        return true;
      }

      if ($this->fuzzyCalibration && ($auntValue < $tickerValue)) {
        return true;
      }
    }

    return false;
  }

  /**
   * @param Aunt $aunt
   * @param int  $tickerValue
   *
   * @return bool
   */
  private function comparePerfumes($aunt, $tickerValue)
  {
    if (
      !is_null($auntValue = $aunt->getPerfumes())
      && ($auntValue === $tickerValue)
    ) {
      return true;
    }

    return false;
  }

  /**
   * @param Aunt $aunt
   * @param int  $tickerValue
   *
   * @return bool
   */
  private function comparePomeranians($aunt, $tickerValue)
  {
    if (!is_null($auntValue = $aunt->getPomeranians())) {
      if (!$this->fuzzyCalibration && ($auntValue === $tickerValue)) {
        return true;
      }

      if ($this->fuzzyCalibration && ($auntValue < $tickerValue)) {
        return true;
      }
    }

    return false;
  }

  /**
   * @param Aunt $aunt
   * @param int  $tickerValue
   *
   * @return bool
   */
  private function compareSamoyeds($aunt, $tickerValue)
  {
    if (
      !is_null($auntValue = $aunt->getSamoyeds())
      && ($auntValue === $tickerValue)
    ) {
      return true;
    }

    return false;
  }

  /**
   * @param Aunt $aunt
   * @param int  $tickerValue
   *
   * @return bool
   */
  private function compareTrees($aunt, $tickerValue)
  {
    if (!is_null($auntValue = $aunt->getTrees())) {
      if (!$this->fuzzyCalibration && ($auntValue === $tickerValue)) {
        return true;
      }

      if ($this->fuzzyCalibration && ($auntValue > $tickerValue)) {
        return true;
      }
    }

    return false;
  }

  /**
   * @param Aunt $aunt
   * @param int  $tickerValue
   *
   * @return bool
   */
  private function compareVizslas($aunt, $tickerValue)
  {
    if (
      !is_null($auntValue = $aunt->getVizslas())
      && ($auntValue === $tickerValue)
    ) {
      return true;
    }

    return false;
  }

}
