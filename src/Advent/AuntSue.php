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

    echo ("Aunt Found: " . $auntName . "\n");
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
        $getter = "get" . ucfirst($category);

        if (
          !is_null($auntValue = $aunt->$getter())
          && ($auntValue === $value)
        ) {
          $matchCount++;
        }
      }

      $analysis[$aunt->getName()] = $matchCount;
    }

    arsort($analysis);
    reset($analysis);

    return key($analysis);
  }

}
