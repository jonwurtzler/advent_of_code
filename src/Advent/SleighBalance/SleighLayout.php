<?php

namespace Advent\SleighBalance;

class SleighLayout
{
  /**
   * @var array
   */
  protected $sleighArea = [
    "leftSide"  => [],
    "rightSide" => [],
    "passenger" => []
  ];

  /**
   * @var int
   */
  protected $maxAreaWeight = 0;

  /**
   * Get what gifts are in a given area.
   *
   * @param string $area
   *
   * @return bool|array
   */
  public function getAreaGifts($area = "passenger")
  {
    if (array_key_exists($area, $this->sleighArea)) {
      return $this->sleighArea[$area];
    }

    return false;
  }

  /**
   * Get the count of gifts in a given area.
   *
   * @param string $area
   *
   * @return bool|int
   */
  public function getAreaGiftCount($area = "passenger")
  {
    if (array_key_exists($area, $this->sleighArea)) {
      return count($this->sleighArea[$area]);
    }

    return false;
  }

  /**
   * Get the product of all the gifts in a given area.
   *
   * @param string $area
   *
   * @return number
   */
  public function getAreaQuantumEntanglement($area = "passenger")
  {
    if (array_key_exists($area, $this->sleighArea)) {
      return array_product($this->sleighArea[$area]);
    }

    return false;
  }

  /**
   * Get a list of possible areas to choose from.
   *
   * @return array
   */
  public function getSleighAreas()
  {
    return array_keys($this->sleighArea);
  }

  /**
   * We know that every group must be the same weight, set the max based on the total weight of gifts.
   *
   * @param int[] $weight
   *
   * @return void
   */
  public function setMaxAreaWeight($weights)
  {
    $totalWeight = array_sum($weights);
    $this->maxAreaWeight = $totalWeight / 3;
  }

  /**
   * Load a gift to an area on the sleigh
   *
   * @param string $area
   * @param int    $weight
   *
   * @return bool
   */
  public function loadGift($area, $weight)
  {
    if (array_key_exists($area, $this->sleighArea)) {
      $this->sleighArea[$area][] = $weight;
    }

    // Make sure that the area is not over weight
    if (array_sum($this->sleighArea[$area]) > $this->maxAreaWeight) {
      return false;
    }

    return true;
  }

}
