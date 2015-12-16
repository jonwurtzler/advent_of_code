<?php

namespace Advent\Ingredient;

class IngredientFactory
{
  /**
   * Create and populate Ingredient
   *
   * @param string $line
   *
   * @return Ingredient
   */
  public function createIngredient($line)
  {
    $properties = $this->parseLine($line);

    $ingredient = new Ingredient();

    foreach ($properties as $property => $value) {
      $setter = "set" . ucfirst($property);
      $ingredient->$setter($value);
    }

    return $ingredient;
  }

  /**
   * Parse file input line into array.
   *
   * @param string $line
   *
   * @return array
   */
  private function parseLine($line)
  {
    $properties         = [];
    $propertyStrings    = explode(", ", rtrim(ltrim(strstr($line, ": "), ": "), "\n"));
    $properties['name'] = strstr($line, ":", true);

    foreach ($propertyStrings as $string) {
      list($name, $value) = explode(" ", $string);
      $properties[$name] = intval($value);
    }

    return $properties;
  }

}
