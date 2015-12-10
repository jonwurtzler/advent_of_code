<?php

namespace Advent;

use Exception;

class WrappingNeeds extends AdventInstructions implements AdventOutputInterface
{

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $totalWrappingPaper = $this->calculateTotalWrappingPaperArea($this->giftsDimensions);
    $totalRibbon        = $this->calculateTotalRibbonArea($this->giftsDimensions);

    echo ("The elves will need: {$totalWrappingPaper} sq ft of wrapping paper\n");
    echo ("The Elves will also need: {$totalRibbon} sq ft of ribbon\n");
  }

  /**
   * Step 1.  Calculate total amount of wrapping paper needed.
   *
   * @return int
   */
  public function calculateTotalWrappingPaperArea($gifts)
  {
    $totalArea = 0;

    for ($i = 0; $i < count($gifts); $i++) {
      $totalArea += $this->wrappingNeeded($gifts[$i]);
    }

    return $totalArea;
  }

  /**
   * Step 2.  Calculate total ribbon needed.
   *
   * @return int
   */
  public function calculateTotalRibbonArea($gifts)
  {
    $ribbonTotalArea = 0;

    for ($i = 0; $i < count($gifts); $i++) {
      $ribbonTotalArea += $this->ribbonNeeded($gifts[$i]);
    }

    return $ribbonTotalArea;
  }

  /**
   * Determine how much wrapping paper will be needed for a package.
   *
   * @param string $dimensions
   *
   * @return int
   * @throws Exception
   */
  private function wrappingNeeded($dimensions)
  {
    $dimArray = $this->splitDimensions($dimensions);

    $giftLength = $dimArray[0];
    $giftWidth  = $dimArray[1];
    $giftHeight = $dimArray[2];

    $side1 = $giftLength * $giftWidth;
    $side2 = $giftLength * $giftHeight;
    $side3 = $giftHeight * $giftWidth;

    $sides = [$side1, $side2, $side3];

    sort($sides);
    $smallest = $sides[0];

    $totalArea = (2 * $side1) + (2 * $side2) + (2 * $side3) + $smallest;

    return $totalArea;
  }

  /**
   * Determine how much ribbon will be needed based on the dimensions.
   *
   * @param string $dimensions
   *
   * @return int
   * @throws Exception
   */
  private function ribbonNeeded($dimensions)
  {
    $dimArray = $this->splitDimensions($dimensions);

    sort($dimArray);

    $ribbonLength = (2 * $dimArray[0]) + (2 * $dimArray[1]);
    $bowLength    = $dimArray[0] * $dimArray[1] * $dimArray[2];

    return $ribbonLength + $bowLength;
  }

  /**
   * Split the dimensions and make sure they are int.
   *
   * @param string $stringDimensions
   *
   * @return int[]
   * @throws Exception
   */
  private function splitDimensions($stringDimensions)
  {
    // dimArray[0] = length
    // dimArray[1] = width
    // dimArray[2] = height
    $dimArray = array_map("intval", explode("x", $stringDimensions));

    if (3 !== count($dimArray)) {
      throw new Exception("Invalid Dimension: {$stringDimensions}");
    } else {
      return $dimArray;
    }
  }

}
