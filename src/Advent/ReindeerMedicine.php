<?php

namespace Advent;

use Exception;
use phpDocumentor\Reflection\DocBlock\Tag\ParamTag;

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
  private $siteInput    = "CRnCaSiRnBSiRnFArTiBPTiTiBFArPBCaSiThSiRnTiBPBPMgArCaSiRnTiMgArCaSiThCaSiRnFArRnSiRnFArTiTiBFArCaCaSiRnSiThCaCaSiRnMgArFYSiRnFYCaFArSiThCaSiThPBPTiMgArCaPRnSiAlArPBCaCaSiRnFYSiThCaRnFArArCaCaSiRnPBSiRnFArMgYCaCaCaCaSiThCaCaSiAlArCaCaSiRnPBSiAlArBCaCaCaCaSiThCaPBSiThPBPBCaSiRnFYFArSiThCaSiRnFArBCaCaSiRnFYFArSiThCaPBSiThCaSiRnPMgArRnFArPTiBCaPRnFArCaCaCaCaSiRnCaCaSiRnFYFArFArBCaSiThFArThSiThSiRnTiRnPMgArFArCaSiThCaPBCaSiRnBFArCaCaPRnCaCaPMgArSiRnFYFArCaSiThRnPBPMgAr";

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
        $this->replacements[$element] = $replacement;
      }
    } else {
      throw new Exception("Failed to load file: " . $filePath);
    }

    fclose($fh);
  }

  private function findMolecules()
  {
    $molecules = [];

    foreach ($this->replacements as $element => $replacement) {
      $lastPos = 0;

      do {
        $molecule = $this->fileInput;

        $elePos = strpos($molecule, $replacement, $lastPos);

        if ($elePos > -1) {
          $lastPos = $elePos;
          $molecule = substr_replace($molecule, $replacement, $elePos);

          if (!in_array($molecule, $molecules)) {
            $molecules[] = $molecule;
          }

          continue;
        }

        break;
      } while ($lastPos < (strlen($this->fileInput) - strlen($element)));
    }

    return count($molecules);
  }
}