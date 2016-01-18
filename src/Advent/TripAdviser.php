<?php namespace Advent;

use Exception;
use Advent\TripAdviser\Trip;

class TripAdviser implements AdventOutputInterface
{

  /**
   * @var array
   */
  protected $completedTrips = [];

  /**
   * @var string
   */
  protected $fileInput = "src/data/map.txt";

  /**
   * @var array
   */
  protected $locations = [];

  /**
   * @var array
   */
  protected $locationList = [];

  /**
   * @var Trip
   */
  protected $lowestTrip;

  /**
   * @var int
   */
  protected $lowestTripDistance = 10000;

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display() {

    $this->loadLocations($this->fileInput);
    $this->calculateShortestDistance();

    $tripCost = "Total Distance: " . $this->lowestTripDistance;
    $history  = "";
    foreach ($this->lowestTrip->getTripLog() as $location => $distance) {
      $history .= "Location: " . $location . " Distance: " . $distance . "\n";
    }

    echo (
      "Lowest Trip: \n" .
      $tripCost . "\n" .
      $history . "\n\n"
    );

  }

  /**
   * Populate elements from the file provided.
   *
   * @param string $filePath
   *
   * @return void
   * @throws Exception
   */
  private function loadLocations($filePath) {
    $fh = fopen($filePath, 'r');

    if ($fh) {
      while (false !== ($line = fgets($fh, 4096))) {
        list($location, , $connection, , $distance) = explode(" ", rtrim($line, "\n"));

        // Add location and connection, both ways
        $this->locations[$location][$connection] = $distance;
        $this->locations[$connection][$location] = $distance;

        // Keep track of all unique locations
        if (!in_array($location, $this->locationList)) {
          $this->locationList[] = $location;
        }

        if (!in_array($connection, $this->locationList)) {
          $this->locationList[] = $connection;
        }
      }
    } else {
      throw new Exception("Failed to load file: " . $filePath);
    }

    fclose($fh);
  }

  /**
   * Method to kick off recursive trip searches.
   */
  private function calculateShortestDistance()
  {
    foreach ($this->locationList as $startingLocation) {
      $trip = new Trip($this->locationList);

      // Set starting location
      $trip->travel($startingLocation, 0);

      // Send to Adviser.
      $this->tripAdviser($trip);
    }

  }

  /**
   * Get a list of locations we can visit based on which we have been to and what are connections to the current location.
   *
   * @param Trip $trip
   *
   * @return array
   */
  private function getAvailableLocations($trip)
  {
    $available = [];

    // Get locations we can go to.
    $lastLocation = $trip->getLastLocation();
    $unvisited    = $trip->getUnvisitedLocations();
    $connections  = $this->locations[$lastLocation];

    // Cycle through the connection and add those still unvisited by the trip.
    foreach ($connections as $connection => $distance) {
      if (in_array($connection, $unvisited)) {
        $available[$connection] = $distance;
      }
    }

    return $available;
  }

  /**
   * Determine where we should go next.
   *
   * @param Trip $trip
   *
   * @return bool
   */
  private function tripAdviser($trip)
  {
    // Remove those we've been to thus far.
    $availableLocations = $this->getAvailableLocations($trip);

    if (count($availableLocations) < 1) {
      return false;
    }

    foreach ($availableLocations as $nextDestination => $distance) {
      $newTrip = clone $trip;
      $newTrip->travel($nextDestination, $distance);

      // Check if complete
      if ($newTrip->isTripComplete()) {
        // Record completed trip
        $this->recordCompletedTrip($newTrip);

        // No other locations would make this any more complete, break
        //break;

      // Continue the trip to the next location.
      } else {
        $this->tripAdviser($newTrip);
      }

    }

    return true;
  }

  /**
   * Save the trip as a successful trip.
   *
   * @param Trip $trip
   */
  private function recordCompletedTrip($trip)
  {
    $distanceTraveled = $trip->getTotalDistanceTraveled();
    $this->completedTrips[$distanceTraveled][] = $trip;

    // If this is the lowest trip, record it.
    if ($distanceTraveled < $this->lowestTripDistance) {
      $this->lowestTrip         = $trip;
      $this->lowestTripDistance = $distanceTraveled;
    }

  }

}
