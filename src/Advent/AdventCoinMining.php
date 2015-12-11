<?php

namespace Advent;

use Exception;

class AdventCoinMining extends AdventInstructions implements AdventOutputInterface
{

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $coinCode  = $this->hackAdventCoinHashes($this->adventCoinCode, 5);
    $coinCode2 = $this->hackAdventCoinHashes($this->adventCoinCode, 6);

    echo ("Advent Coin Code (5): {$coinCode}\n");
    echo ("Advent Coin Code (6): {$coinCode2}\n");
  }

  /**
   * Looking for the int added to the code to get an md5 has starting with '00000'.
   *
   * @param string $code
   *
   * @return int
   */
  public function hackAdventCoinHashes($code, $numOfZeros)
  {
    $i = 0;
    $zeroString = $this->generateZeroString($numOfZeros);

    do {
      $testCode = $code . $i;
      $hash     = md5($testCode);

      if (0 === strpos($hash, $zeroString)) {
        break;
      }

      $i++;
    } while(true);

    return $i;
  }

  /**
   * Create a string made up of $num 0's.
   *
   * @param int $num
   *
   * @return string
   * @throws Exception
   */
  private function generateZeroString($num) {
    if ($num > 0) {
      return sprintf("%1$0" . $num . "d", "");
    }

    throw new Exception("Please provide a positive number to generate zero string");
  }
}