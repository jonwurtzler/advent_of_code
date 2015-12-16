<?php

namespace Advent\Reindeer;


class ReindeerFactory
{
  public function createReindeer($line) {
    list($name, , , $flySpeed, , , $flightDuration, , , , , , , $restTime) = explode(" ", $line);

    $reindeer = new Reindeer();

    $reindeer
      ->setName($name)
      ->setFlySpeed($flySpeed)
      ->setFlightDuration($flightDuration)
      ->setRestTime($restTime);

    return $reindeer;
  }
}