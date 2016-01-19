<?php namespace Advent;

use Advent\KnightsTable\Knight;
use Advent\KnightsTable\Table;
use Exception;

/**
 * Class KnightsTable
 * @package Advent
 *
 * Step 1
 * Try 1: 498 (Failed, too low)
 * Carol -> (149) -> FrankAlice -> (57) -> BobDavid -> (98) -> GeorgeMallory -> (100) -> Eric -> (94)
 * Wasn't handling each space correctly.
 *
 * Try 2: 709 (Success!)
 * Alice -> (57) -> Bob -> (87) -> Mallory -> (100) -> Eric -> (94) -> Carol -> (149) ->
 * Frank -> (41) -> David -> (98) -> George -> (83)
 *
 * Step 2
 * Try 1: 668 (Success!)
 * Alice -> (57) -> Bob -> (87) -> Mallory -> (100) -> Eric -> (94) -> Carol -> (149) ->
 * Frank -> (0) -> Me -> (0) -> David -> (98) -> George -> (83)
 */
class KnightsTable implements AdventOutputInterface
{

  /**
   * @var string
   */
  protected $fileInput = "src/data/seating.txt";

  /**
   * @var array
   */
  protected $fullTables = [];

  /**
   * @var array
   */
  protected $guestList = [];

  /**
   * @var int
   */
  protected $holyKnightHappiness = 0;

  /**
   * @var Table
   */
  protected $holyKnightTable;

  /**
   * @var array
   */
  protected $knights = [];

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display() {

    $this->loadSeatingChart($this->fileInput);
    $this->seatVisitingKnights();

    // Short trip output
    $holyHappiness = "Total Happiness: " . $this->holyKnightHappiness;
    $holySeating   = $this->holyKnightTable->getSeatingOutput();

    echo (
      "Holy Table (without me): \n" .
      $holyHappiness . "\n" .
      $holySeating . "\n\n"
    );

    // Add me as guest
    $this->resetHolyTable();
    $this->addMeAsKnight();
    $this->seatVisitingKnights();

    // Short trip output
    $holyHappiness = "Total Happiness: " . $this->holyKnightHappiness;
    $holySeating   = $this->holyKnightTable->getSeatingOutput();

    echo (
      "Holy Table (with me): \n" .
      $holyHappiness . "\n" .
      $holySeating . "\n\n"
    );
  }

  /**
   * Add myself to the list of guests to be seated.
   */
  private function addMeAsKnight()
  {
    $me = new Knight("Me");
    foreach ($this->knights as $knight) {
      /** @var Knight $knight */
      $me->setHappiness($knight->getName(), 0);
    }

    $this->guestList[]   = "Me";
    $this->knights["Me"] = $me;
  }

  /**
   * Populate elements from the file provided.
   *
   * @param string $filePath
   *
   * @return void
   * @throws Exception
   */
  private function loadSeatingChart($filePath) {
    $fh = fopen($filePath, 'r');

    if ($fh) {
      while (false !== ($line = fgets($fh, 4096))) {
        list($knightName, , $modifier, $happiness, , , , , , , $nextTo) = explode(" ", rtrim($line, ".\n"));

        // Make sure happiness is an int value.
        $happiness = intval($happiness);

        // Make a negative number if they would lose happiness.
        if ($modifier === "lose") {
          $happiness *= -1;
        }

        // Add person and the happiness they would gain/lose sitting next to $nextTo.
        if (!array_key_exists($knightName, $this->knights)) {
          $knight = new Knight($knightName);

          // Update guest list.
          $this->guestList[] = $knightName;
        } else {
          $knight = $this->knights[$knightName];
        }

        $knight->setHappiness($nextTo, $happiness);

        $this->knights[$knightName] = $knight;
      }
    } else {
      throw new Exception("Failed to load file: " . $filePath);
    }

    fclose($fh);
  }

  /**
   * Record a fully seated table.
   *
   * @param Table $table
   */
  private function recordFullTable($table)
  {
    $happiness = $table->calculateHappiness();
    $this->fullTables[$happiness] = $table;

    // Determine if this is a holy table (positive happiness).
    if ($happiness > $this->holyKnightHappiness) {
      $this->holyKnightHappiness = $happiness;
      $this->holyKnightTable     = $table;
    }
  }

  /**
   * Reset the holy table information to run another seating with new guest.
   */
  private function resetHolyTable()
  {
    $this->fullTables          = [];
    $this->holyKnightTable     = null;
    $this->holyKnightHappiness = 0;
  }

  /**
   * Seat the first knight and allow the royal page to handle the rest.
   */
  private function seatVisitingKnights()
  {
    foreach ($this->knights as $knightName => $knight) {
      $table = new Table($this->guestList);

      $table->seatKnight($knight);

      $this->royalSeatingPage($table);
    }
  }

  /**
   * Royal Page to seat the next guest.
   *
   * @param Table $table
   */
  private function royalSeatingPage($table)
  {
    foreach ($table->remainingKnights() as $knightName) {
      $newTable = clone $table;

      $newTable->seatKnight($this->knights[$knightName]);

      if ($newTable->isEveryoneSeated()) {
        $this->recordFullTable($newTable);
      } else {
        $this->royalSeatingPage($newTable);
      }
    }
  }

}
