<?php namespace Advent\TripAdviser;

class Trip
{

  /**
   * The last location visited in the trip.
   *
   * @var string
   */
  protected $lastLocation = "";

  /**
   * Total distance the trip has covered.
   *
   * @var int
   */
  protected $totalDistance = 0;

  /**
   * Order of locations traveled during a given trip.
   *
   * @var array
   */
  protected $travelLog = [];

  /**
   * Locations to visit in order to complete the trip.
   *
   * @var array
   */
  protected $tripLocations = [];

  /**
   * Set the locations we need to visit to have a completed trip.
   *
   * @param array $locations
   */
  public function __construct($locations) {
    $this->tripLocations = $locations;
  }

  /**
   * Return the last visited city to determine where we can go next.
   *
   * @return string
   */
  public function getLastLocation()
  {
    return $this->lastLocation;
  }

  /**
   * Total distance traveled by this trip.
   *
   * @return int
   */
  public function getTotalDistanceTraveled()
  {
    return $this->totalDistance;
  }

  /**
   * Get the total trips log.
   *
   * @return array
   */
  public function getTripLog()
  {
    return $this->travelLog;
  }

  /**
   * List the locations this trip has not visited.
   *
   * @return array
   */
  public function getUnvisitedLocations()
  {
    return array_diff($this->tripLocations, array_keys($this->travelLog));
  }

  /**
   * Determine if the trip is complete.
   *
   * @return bool
   */
  public function isTripComplete()
  {
    if (count(array_diff($this->tripLocations, array_keys($this->travelLog))) < 1) {
      return true;
    }

    return false;
  }

  /**
   * Go to the next location and record it.
   *
   * @param string $location
   * @param int    $distance
   *
   * @return int
   */
  public function travel($location, $distance)
  {
    $this->lastLocation         = $location;
    $this->travelLog[$location] = $distance;
    $this->totalDistance        += $distance;

    return $this->totalDistance;
  }

}
