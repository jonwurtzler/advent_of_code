<?php

namespace Advent;

class NaughtyNiceList extends AdventInstructions implements AdventOutputInterface
{
  /**
   * @var array
   */
  protected $vowels = ["a", "e", "i", "o", "u"];

  /**
   * @var array
   */
  protected $naughtySets = ["ab", "cd", "pq", "xy"];

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display() {
    $niceListCount         = $this->checkList($this->naughtyAndNiceList);
    $niceListAdvancedCount = $this->checkList($this->naughtyAndNiceList, true);

    echo ("Number of nice strings: {$niceListCount}\n");
    echo ("Number of nice advanced strings: {$niceListAdvancedCount}\n");
  }

  /**
   * Iterate over the list and count how many are nice.
   *
   * @param array $list
   *
   * @return int
   */
  public function checkList($list, $advanced = false)
  {
    $niceCount = 0;

    foreach ($list as $item) {
      if ($advanced) {
        $nice = $this->isNiceAdvanced($item);
      } else {
        $nice = $this->isNice($item);
      }

      if ($nice) {
        $niceCount++;
      }
    }

    return $niceCount;
  }

  /*
  | -------------------------------------------------------------------
  |  Step 1
  | -------------------------------------------------------------------
  */

  /**
   * Determine if a string is nice based on rules.
   *
   * @param string $string
   *
   * @return bool
   */
  private function isNice($string)
  {
    $doubleCheck = "";
    $hasDouble   = false;
    $vowelCount  = 0;

    if (!$this->isNaughty($string)) {
      for ($i = 0; $i < strlen($string); $i++) {
        if (in_array($string[$i], $this->vowels)) {
          $vowelCount++;
        }

        if ($string[$i] === $doubleCheck) {
          $hasDouble = true;
        } else {
          $doubleCheck = $string[$i];
        }

        if (($vowelCount > 2) && $hasDouble) {
          return true;
        }
      }
    }

    return false;
  }

  /**
   * Check string for naughty elements.
   *
   * @param string $string
   *
   * @return bool
   */
  private function isNaughty($string)
  {
    foreach ($this->naughtySets as $set) {
      if (strpos($string, $set) > -1) {
        return true;
      }
    }

    return false;
  }

  /*
  | -------------------------------------------------------------------
  |  Step 2
  | -------------------------------------------------------------------
  */

  /**
   * Check if a string is nice on the advanced rules. (step 2).
   *
   * @param string $string
   *
   * @return bool
   */
  private function isNiceAdvanced($string)
  {
    $doubleSet = $this->doubleSet($string);
    $skipSame  = $this->skipSame($string);

    if ($doubleSet && $skipSame) {
      return true;
    }

    return false;
  }

  /**
   * Check for two sets of matching characters that don't overlap.
   *
   * @param string $string
   *
   * @return bool
   */
  private function doubleSet($string)
  {
    $len = strlen($string);

    for ($i = 0; $i < ($len - 3); $i++) {
      $root = substr($string, $i, 2);
      $remaining = substr($string, $i + 2);

      if (strpos($remaining, $root) > -1) {
        return true;
      }
    }

    return false;
  }

  /**
   * Check for duplicates with one char between them.
   *
   * @param string $string
   *
   * @return bool
   */
  private function skipSame($string)
  {
    $len = strlen($string);

    for ($i = 0; $i < ($len - 2); $i++) {
      if ($string[$i] === $string[$i + 2]) {
        return true;
      }
    }

    return false;
  }

}
