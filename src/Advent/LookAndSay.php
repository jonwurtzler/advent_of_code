<?php

namespace Advent;

use Exception;

class LookAndSay implements AdventOutputInterface
{
  /**
   * @var string
   */
  protected $siteInput = "1113222113";

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display() {
    $lasLength40 = $this->lookAndSay($this->siteInput);
    $lasLength50 = $this->lookAndSay($this->siteInput, 50);

    echo ("Look and Say after 40 runs: {$lasLength40}\n");
    echo ("Look and Say after 50 runs: {$lasLength50}\n");
  }

  /**
   * @param string $input
   * @param int    $iteration
   *
   * @return int
   * @throws Exception
   */
  public function lookAndSay($input, $iteration = 40)
  {
    $lookString = "";
    $lookCount  = 0;
    $sayString  = "";

    if (!is_numeric($input)) {
      throw new Exception("Please enter only numeric values");
    }

    if ($iteration-- > 0) {
      for ($i = 0; $i < strlen($input); $i++) {
        if (empty($lookString)) {
          $lookString = $input[$i];
          $lookCount++;
          continue;
        }

        if ($input[$i] === $lookString) {
          $lookCount++;
        } else {
          $sayString .= $lookCount . $lookString;
          $lookString = $input[$i];
          $lookCount  = 1;
        }
      }

      // Finish remaining
      $sayString .= $lookCount . $lookString;

      return $this->lookAndSay($sayString, $iteration);
    }

    return strlen($input);
  }
}
