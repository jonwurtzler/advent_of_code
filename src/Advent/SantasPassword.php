<?php

namespace Advent;


class SantasPassword implements AdventOutputInterface
{
  /**
   * @var array
   */
  protected $invalidCharacters = ["i", "l", "o"];

  /**
   * @var string
   */
  protected $siteInput1 = "hepxcrrq";

  /**
   * @var string
   */
  protected $siteInput2 = "hepxxyzz";


  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $firstPass  = $this->getNextPassword($this->siteInput1);
    $secondPass = $this->getNextPassword($this->siteInput2);

    echo ("Santa's First New Password should be: {$firstPass}\n");
    echo ("Santa's Second New Password should be: {$secondPass}\n");
  }

  /**
   * Master process for running the passwords.
   *    - Make sure no invalid characters
   *    - Make sure at least 2 sets of non-overlapping doubles
   *    - Make sure at least one series of three characters in a row.
   *
   * @param string $oldPass
   *
   * @return string
   */
  public function getNextPassword($oldPass)
  {
    $pass = ++$oldPass;

    do {
      // Get next possible string without invalid characters
      $pass = $this->removeInvalid($pass);

      // Check for doubles
      if (!$this->checkDoubles($pass)) {
        $pass = $this->getNewTest($pass);
        continue;
      }

      // Check for a series.
      if (!$this->checkSeries($pass)) {
        $pass = $this->getNewTest($pass);
        continue;
      }

      // If we got to this point, it's valid, break out of do/while.
      break;
    } while (true);

    return $pass;
  }

  /**
   * Make sure we have two sets of non-overlapping doubles.
   *
   * @param string $pass
   *
   * @return bool
   */
  private function checkDoubles($pass)
  {
    $doubleCount  = 0;
    $doubleString = "";

    for ($i = 0; $i < strlen($pass); $i++) {
      if (empty($doubleString)) {
        $doubleString = $pass[$i];
        continue;
      }

      if ($doubleString === $pass[$i]) {
        if(++$doubleCount > 1) {
          return true;
        } else {
          $doubleString = "";
        }
      } else {
        $doubleString = $pass[$i];
      }
    }

    return false;
  }

  /**
   * Make sure we have a series of three characters 'abc', 'xyz'
   *
   * @param string $pass
   *
   * @return bool
   */
  private function checkSeries($pass)
  {
    $seriesString = "";

    for ($i = 0; $i < strlen($pass); $i++) {
      if (empty($seriesString)) {
        $seriesString = $pass[$i];
        continue;
      }

      $lastChar = substr($seriesString, -1);
      if (++$lastChar === $pass[$i]) {
        if (strlen($seriesString) > 1) {
          return true;
        }

        $seriesString .= $lastChar;
      } else {
        $seriesString = "";
      }
    }

    return false;
  }

  /**
   * Make sure we don't have invalid characters.  If so, search until we get the next string in line that is valid.
   *
   * @param string $pass
   *
   * @return string
   */
  private function removeInvalid($pass)
  {
    for ($i = 0; $i < strlen($pass); $i++) {
      if (in_array($pass[$i], $this->invalidCharacters)) {
        return $this->removeInvalid($this->skipForInvalid($pass, $i));
        break;
      }
    }

    return $pass;
  }

  /**
   * If we have an invalid character, set all characters that come after that to z's and then increment to get past it.
   *   Skips iterating over all of them between the invalid sets.
   *
   * @param string $pass
   * @param int    $index
   *
   * @return string
   */
  private function skipForInvalid($pass, $index)
  {
    $index++;
    $subLen  = strlen($pass) - $index;
    if ($subLen > 0) {
      $zString = str_repeat("z", $subLen);
      $pass    = substr_replace($pass, $zString, $index, $subLen);
    }

    return $this->getNewTest($pass);
  }

  /**
   * Method to get us the next string in line.  Skips invalid characters coming next.
   *
   * @param string $pass
   *
   * @return string
   */
  private function getNewTest($pass)
  {
    $last = substr($pass, -1);
    if (in_array(++$last, $this->invalidCharacters)) {
      ++$pass;
    }

    return ++$pass;
  }

}
