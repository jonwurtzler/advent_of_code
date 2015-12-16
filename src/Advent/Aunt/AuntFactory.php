<?php

namespace Advent\Aunt;

class AuntFactory
{
  /**
   * @param string $line
   *
   * @return aunt
   */
  public function createAunt($line)
  {
    $knowns = $this->parseLine($line);

    $aunt = new Aunt();

    foreach ($knowns as $known => $value) {
      $setter = "set" . ucfirst($known);
      $aunt->$setter($value);
    }

    return $aunt;
  }

  /**
   * @param $line
   *
   * @return array
   */
  private function parseLine($line)
  {
    $known         = [];
    $knownStrings  = explode(", ", rtrim(ltrim(strstr($line, ": "), ": "), "\n"));
    $known['name'] = strstr($line, ":", true);

    foreach ($knownStrings as $string) {
      list($name, $value) = explode(": ", $string);
      $known[$name] = intval($value);
    }

    return $known;
  }

}
