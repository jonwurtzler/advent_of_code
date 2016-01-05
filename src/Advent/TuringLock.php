<?php

namespace Advent;

use Exception;

class TuringLock implements AdventOutputInterface
{
  /**
   * @var array
   */
  protected $commands = ["hlf", "tpl", "inc", "jmp", "jie", "jio"];

  /**
   * @var string
   */
  protected $fileInput = "src/data/lock.txt";

  /**
   * @var array
   */
  protected $history = [];

  /**
   * @var array
   */
  protected $lockCommands = [];

  /**
   * @var int
   */
  protected $registers = [
    "a" => 0,
    "b" => 0
  ];

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $history = "";
    $showHistory = false;
    $this->loadLockCommands($this->fileInput);
    $this->runLockCommands();

    if ($showHistory) {
      $history = "History: \n" . implode("\n", $this->history);
    }

    echo (
      "Total Commands Run, Part 1: " . count($this->history) . " \n" .
      "Register A: " . $this->registers["a"] . "\n" .
      "Register B: " . $this->registers["b"] . "\n\n" . $history
    );

    $this->registers = ["a" => 1, "b" => 0];
    $this->history = [];
    $this->runLockCommands();

    if ($showHistory) {
      $history = "History: \n" . implode("\n", $this->history);
    }

    echo (
      "Total Commands Run, Part 2: " . count($this->history) . " \n" .
      "Register A: " . $this->registers["a"] . "\n" .
      "Register B: " . $this->registers["b"] . "\n\n" . $history
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
  private function loadLockCommands($filePath) {
    $fh = fopen($filePath, 'r');

    if ($fh) {
      while (false !== ($line = fgets($fh, 4096))) {
        $this->lockCommands[] = rtrim($line, "\n");
      }
    } else {
      throw new Exception("Failed to load file: " . $filePath);
    }

    fclose($fh);
  }

  /**
   * Go through all the commands to get the values of A and B.
   *
   * @return void
   * @throws Exception
   */
  private function runLockCommands()
  {
    $i = 0;
    $totalCommands = count($this->lockCommands);

    do {
      $this->history[] = $i;

      $command = str_replace(",", "", $this->lockCommands[$i]);

      $commandParts = explode(" ", $command);
      $cmd          = $commandParts[0];
      $register     = $commandParts[1];
      $offset       = null;

      if (count($commandParts) > 2) {
        $offset = $commandParts[2];
      }

      if (in_array($cmd, $this->commands)) {
        switch ($cmd) {
          case "hlf":
            $this->registers[$register] /= 2;
            $i++;
            break;
          case "tpl":
            $this->registers[$register] *= 3;
            $i++;
            break;
          case "inc":
            $this->registers[$register]++;
            $i++;
            break;
          case "jmp":
            $sign   = $register[0];
            $offset = intval(substr($register, 1));

            if ($sign === "-") { $offset *= -1; }
            $i += $offset;
            break;
          case "jie":
            $sign   = $offset[0];
            $offset = intval(substr($offset, 1));

            if ($sign === "-") { $offset *= -1; }

            if (($this->registers[$register] % 2) == 0) {
              $i += $offset;
            } else {
              $i++;
            }

            break;
          case "jio":
            $sign   = $offset[0];
            $offset = intval(substr($offset, 1));

            if ($sign === "-") { $offset *= -1; }

            if ($this->registers[$register] === 1) {
              $i += $offset;
            } else {
              $i++;
            }
            break;
        }

        // Check if we're going out of bounds
        //  Any over will be handled by the for statement.
        if (0 > $i) {
          break;
        }
      } else {
        throw new Exception("Invalid command " . $cmd);
      }
    } while ($i < $totalCommands);

  }

}
