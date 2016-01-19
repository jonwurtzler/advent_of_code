<?php namespace Advent\KnightsTable;

use SplDoublyLinkedList;

class Table
{

  /**
   * List of those that should be seated.
   *
   * @var array
   */
  protected $guestList = [];

  /**
   * List of those currently seated.
   *
   * @var array
   */
  protected $seated = [];

  /**
   * @var SplDoublyLinkedList
   */
  protected $seating;

  /**
   * @var int
   */
  protected $tableHappiness = 0;

  public function __construct($guestList) {
    $this->guestList = $guestList;
    $this->seating   = new SplDoublyLinkedList();
  }

  function __clone()
  {
    $this->seating = clone $this->seating;
  }

  /**
   * Calculate table happiness and return in.
   *
   * @return int
   */
  public function calculateHappiness()
  {
    if ($this->seating->count() > 1) {
      $this->seating->rewind();

      for ($this->seating->rewind(); $this->seating->valid(); $this->seating->next()) {
        $currKnight = $this->seating->current();

        if (($this->seating->key() + 1) < $this->seating->count()) {
          $nextKnight = $this->seating->offsetGet($this->seating->key() + 1);
          $this->tableHappiness += $this->calculateHappinessChange($currKnight, $nextKnight);
        } else {
          $this->seating->rewind();
          $nextKnight = $this->seating->current();
          $this->tableHappiness += $this->calculateHappinessChange($currKnight, $nextKnight);
          break;
        }
      }

    }

    return $this->tableHappiness;
  }

  /**
   * Generate an output for the current seating.
   *
   * @return string
   */
  public function getSeatingOutput()
  {
    $seatingOutput = "";

    for ($this->seating->rewind(); $this->seating->valid(); $this->seating->next()) {
      $currKnight = $this->seating->current();

      if (($this->seating->key() + 1) < $this->seating->count()) {
        $nextKnight      = $this->seating->offsetGet($this->seating->key() + 1);
        $gainedHappiness = $this->calculateHappinessChange($currKnight, $nextKnight);
        $seatingOutput   .= $currKnight->getName() . " -> (" . $gainedHappiness . ") -> ";
      } else {
        $this->seating->rewind();
        $nextKnight      = $this->seating->current();
        $gainedHappiness = $this->calculateHappinessChange($currKnight, $nextKnight);
        $seatingOutput   .= $currKnight->getName() . " -> (" . $gainedHappiness . ")";

        break;
      }
    }

    return $seatingOutput;
  }

  /**
   * Check if the seated list matches the guest list.
   *
   * @return bool
   */
  public function isEveryoneSeated()
  {
    if (count(array_diff($this->guestList, $this->seated)) < 1) {
      return true;
    }

    return false;
  }

  /**
   * List of Knights on the guest list but not yet seated.
   *
   * @return array
   */
  public function remainingKnights()
  {
    return array_diff($this->guestList, $this->seated);
  }

  /**
   * Seat a knight at the table.
   *
   * @param Knight $knight
   */
  public function seatKnight($knight)
  {
    $this->seated[] = $knight->getName();
    $this->seating->push($knight);
  }

  /**
   * Determine the total happiness change by two knights sitting next to each other.
   *
   * @param Knight $knight1
   * @param Knight $knight2
   *
   * @return int
   */
  private function calculateHappinessChange($knight1, $knight2)
  {
    $knight1Happiness = $knight1->getHappiness($knight2);
    $knight2Happiness = $knight2->getHappiness($knight1);

    return ($knight1Happiness + $knight2Happiness);
  }

}
