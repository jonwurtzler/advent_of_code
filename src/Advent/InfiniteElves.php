<?php

namespace Advent;

use SplFixedArray;

class InfiniteElves implements AdventOutputInterface
{

  private $siteInput = 34000000;

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $houseNumber        = $this->houseNumber($this->siteInput);
    $houseNumberLimited = $this->houseNumber($this->siteInput, true);

    echo ("Lowest House Number: " . $houseNumber . "\n");
    echo ("Lowest Limited Visits House Number: " . $houseNumberLimited . "\n");
  }

  /**
   * Cycle through an arbatrary number of houses hoping to get to the target number.
   *
   * @param int  $number
   * @param bool $limit50
   *
   * @return int
   */
  public function houseNumber($number, $limit50 = false)
  {
    $size         = 1000000;
    $houses       = new SplFixedArray($size);
    $lowestHouse  = 1;

    for ($elf = 1; $elf < $size; $elf++) {
      if (!$limit50) {
        for ($visited = $elf; $visited < $size; $visited += $elf) {
          if (is_null($houses[$visited])) { $houses[$visited] = 0; }
          $houses[$visited] += ($elf * 10);
        }
      } else {
        for (
          $visited = $elf, $visits = 0;
          ($visited < $size) && ($visits < 50);
          $visited += $elf, $visits++
        ) {
          if (is_null($houses[$visited])) { $houses[$visited] = 0; }
          $houses[$visited] += ($elf * 11);
        }
      }
    }

    foreach ($houses as $house => $value) {
      if ($value >= $number) {
        $lowestHouse = $house;
        break;
      }
    }

    return $lowestHouse;
  }

}
