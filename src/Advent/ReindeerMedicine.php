<?php

namespace Advent;

use Exception;

class ReindeerMedicine implements AdventOutputInterface
{

  /**
   * @var string
   */
  protected $fileInput = "src/data/moleculeReplacement.txt";

  /**
   * @var array
   */
  private $replacements = [];

  /**
   * @var string
   */
  private $siteInput = "CRnCaSiRnBSiRnFArTiBPTiTiBFArPBCaSiThSiRnTiBPBPMgArCaSiRnTiMgArCaSiThCaSiRnFArRnSiRnFArTiTiBFArCaCaSiRnSiThCaCaSiRnMgArFYSiRnFYCaFArSiThCaSiThPBPTiMgArCaPRnSiAlArPBCaCaSiRnFYSiThCaRnFArArCaCaSiRnPBSiRnFArMgYCaCaCaCaSiThCaCaSiAlArCaCaSiRnPBSiAlArBCaCaCaCaSiThCaPBSiThPBPBCaSiRnFYFArSiThCaSiRnFArBCaCaSiRnFYFArSiThCaPBSiThCaSiRnPMgArRnFArPTiBCaPRnFArCaCaCaCaSiRnCaCaSiRnFYFArFArBCaSiThFArThSiThSiRnTiRnPMgArFArCaSiThCaPBCaSiRnBFArCaCaPRnCaCaPMgArSiRnFYFArCaSiThRnPBPMgAr";

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $this->loadMoleculeReplacements($this->fileInput);
    $distinctMolecules = $this->findMolecules();

    echo ("Total Distinct Molecules: " . $distinctMolecules . " \n");
  }

  /**
   * Populate elements from the file provided.
   *
   * @param string $filePath
   *
   * @return void
   * @throws Exception
   */
  private function loadMoleculeReplacements($filePath) {
    $fh = fopen($filePath, 'r');

    if ($fh) {
      while (false !== ($line = fgets($fh, 4096))) {
        list($element, $replacement) = explode(" => ", rtrim($line, "\n"));
        $this->replacements[] = [$element, $replacement];
      }
    } else {
      throw new Exception("Failed to load file: " . $filePath);
    }

    fclose($fh);
  }

  /**
   * Go through and replace each 'element' with it's replacement.
   *
   * @return int
   */
  private function findMolecules()
  {
    $molecules = [];

    foreach ($this->replacements as $elementProperties) {
      $lastPos = 0;
      list($element, $replacement) = $elementProperties;

      do {
        $molecule = $this->siteInput;

        $elePos = strpos($molecule, $element, $lastPos);

        if ($elePos > -1) {
          $lastPos  = ($elePos + 1);
          $molecule = substr_replace($molecule, $replacement, $elePos, strlen($element));

          if (!in_array($molecule, $molecules)) {
            $molecules[] = $molecule;
          }

          continue;
        }

        break;
      } while ($lastPos < (strlen($this->siteInput) - strlen($element)));
    }

    return count($molecules);
  }

  /*
   * Part 2
   *
   * CRnCaSiRnBSiRnFArTiBPTiTiBFArPBCaSiThSiRnTiBPBPMgArCaSiRnTiMgArCaSiThCaSiRnFArRnSiRnFArTiTiBFArCaCaSiRnSiThCaCaSiRnMgArFYSiRnFYCaFArSiThCaSiThPBPTiMgArCaPRnSiAlArPBCaCaSiRnFYSiThCaRnFArArCaCaSiRnPBSiRnFArMgYCaCaCaCaSiThCaCaSiAlArCaCaSiRnPBSiAlArBCaCaCaCaSiThCaPBSiThPBPBCaSiRnFYFArSiThCaSiRnFArBCaCaSiRnFYFArSiThCaPBSiThCaSiRnPMgArRnFArPTiBCaPRnFArCaCaCaCaSiRnCaCaSiRnFYFArFArBCaSiThFArThSiThSiRnTiRnPMgArFArCaSiThCaPBCaSiRnBFArCaCaPRnCaCaPMgArSiRnFYFArCaSiThRnPBPMgAr
   *
   *
   * Number of elements
   * Following solution as found: https://www.reddit.com/r/adventofcode/comments/3xflz8/day_19_solutions/cy4etju
   *
   * Al = 3
   * B  = 22
   * Ca = 52
   * F  = 26
   * H  = 0
   * Mg = 9
   * N  = 0
   * O  = 0
   * P  = 23
   * Si = 41
   * Th = 17
   * Ti = 10
   * Rn = 31
   * Y  = 8
   * Ar = 31
   *
   * Total = 273 - 62 - (8*2) = 195
   */
}