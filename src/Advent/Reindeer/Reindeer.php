<?php

namespace Advent\Reindeer;


class Reindeer
{

  /**
   * @var int
   */
  protected $flySpeed;

  /**
   * @var int
   */
  protected $flightDuration;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var int
   */
  protected $restTime;

  /**
   * @return int
   */
  public function getFlySpeed()
  {
    return $this->flySpeed;
  }

  /**
   * @return int
   */
  public function getFlightDuration()
  {
    return $this->flightDuration;
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @return int
   */
  public function getRestTime()
  {
    return $this->restTime;
  }

  /**
   * @param int $flySpeed
   *
   * @return $this
   */
  public function setFlySpeed($flySpeed)
  {
    $this->flySpeed = $flySpeed;

    return $this;
  }

  /**
   * @param int $flySpeed
   *
   * @return $this
   */
  public function setFlightDuration($flightDuration)
  {
    $this->flightDuration = $flightDuration;

    return $this;
  }

  /**
   * @param int $restTime
   *
   * @return $this
   */
  public function setRestTime($restTime)
  {
    $this->restTime = $restTime;

    return $this;
  }

  /**
   * @param string $name
   *
   * @return $this
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Determine how far the reindeer has traveled after x seconds.
   * @param int $time
   *
   * @return int
   */
  public function distanceTraveled($timeInSeconds)
  {
    $distance = 0;
    $i        = 0;
    $state    = 0;

    do {
      // Flying
      if (0 === ($state % 2)) {
        if (($i + $this->flightDuration) <= $timeInSeconds) {
          $distance += ($this->flightDuration * $this->flySpeed);
          $i        += $this->flightDuration;

          $state++; // Take a breather.

          continue;

        // Finish out the rest flying
        } else {
          $distance += (($timeInSeconds - $i) * $this->flySpeed);
          break;
        }

        // Resting
      } else {
        if (($i + $this->restTime) <= $timeInSeconds) {
          $i += $this->restTime;

          $state++;  // Back to Flying!!

          continue;

        // Finishing out resting
        } else {
          break;
        }
      }
    } while ($i < $timeInSeconds);

    return $distance;
  }

}
