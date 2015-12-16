<?php

namespace Advent;

use Exception;

class ElfAccounting implements AdventOutputInterface
{

  /**
   * @var string
   */
  protected $accountingString = "";

  /**
   * @var string
   */
  protected $fileInput = "src/data/accounting.txt";

  /**
   * @var
   */
  protected $json;

  /**
   * @var bool
   */
  protected $withRed = true;

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $this->loadAccountingJson($this->fileInput);

    $accountingTotal           = $this->getSum();
    $this->withRed             = false;
    $accountingTotalWithoutRed = $this->getSum();

    echo ("Elf Accounting Total: " . $accountingTotal . "\n");
    echo ("Elf Accounting Total without red: " . $accountingTotalWithoutRed . "\n");
  }

  /**
   * Read the accounting json file.
   *
   * @param string $filePath
   *
   * @return void
   * @throws Exception
   */
  private function loadAccountingJson($filePath)
  {
    $contents = file_get_contents($filePath);

    if ($contents) {
      $this->accountingString = $contents;
    } else {
      throw new Exception("Failed to load file: " . $filePath);
    }
  }

  /**
   * Remove unneeded characters and get total of numbers.
   *
   * @return number
   */
  private function getSum()
  {
    $baseReplace = "/\".+?\"|[\,\:\{\}\[\]]/";
    $baseString  = $this->accountingString;

    if (!$this->withRed) {
      $baseString = json_encode($this->removeRed());
    }

    $str = preg_replace('/\s\s+/', " ", preg_replace($baseReplace, " ", $baseString));
    return array_sum(explode(" ", $str));
  }

  private function removeRed()
  {
    $json = json_decode($this->accountingString);
    $json = $this->lookForRed($json);

    return $json;
  }

  /**
   * Iterate through the base json objects.
   *
   * @param object|array $json
   *
   * @return array
   */
  private function lookForRed($json)
  {
    foreach ($json as $elementName => $element) {
      if (is_array($element)) {
        if (is_array($json)) {
          $json[$elementName] = $this->lookForRedInArray($element);
        } else {
          $json->$elementName = $this->lookForRedInArray($element);
        }
      } elseif (is_object($element)) {
        if (is_array($json)) {
          $json[$elementName] = $this->lookForRedInObject($element);
        } else {
          $json->$elementName = $this->lookForRedInObject($element);
        }
      }
    }

    return $json;
  }

  /**
   * Iterate through the arrays looking for other objects that might need to be removed.
   *
   * @param array $array
   *
   * @return array
   */
  private function lookForRedInArray($array) {
    foreach ($array as $name => $value) {
      if (is_array($value)) {
        $array[$name] = $this->lookForRedInArray($value);
      } elseif (is_object($value)) {
        $array[$name] = $this->lookForRedInObject($value);
      }
    }

    return $array;
  }

  /**
   * Determine if we need to remove the object because of it being red.
   *
   * @param object $obj
   *
   * @return object
   */
  private function lookForRedInObject($obj) {
    foreach ($obj as $propertyName => $property) {
      if ($propertyName === "red") {
        $obj = (object)[];
        break;
      }

      if (is_array($property)) {
        $obj->$propertyName = $this->lookForRedInArray($property);
      } elseif (is_object($property)) {
        $obj->$propertyName = $this->lookForRedInObject($property);
      } else {
        if ($property === "red") {
          $obj = (object)[];
          break;
        }
      }
    }

    return $obj;
  }

}
