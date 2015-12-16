<?php

namespace Advent;

use Advent\Ingredient\Ingredient;
use Advent\Ingredient\IngredientFactory;
use Exception;

class CookieRecipe implements AdventOutputInterface
{

  /**
   * @var bool
   */
  protected $calorie500 = false;

  /**
   * @var Ingredient[]
   */
  protected $ingredients = [];

  /**
   * @var string
   */
  protected $fileInput = "src/data/ingredients.txt";

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $this->loadIngredients($this->fileInput);

    $recipe           = $this->findBestRecipe();
    $this->calorie500 = true;
    $calorie500Recipe = $this->findBestRecipe();

    echo ("Recipe Found:\n" . key($recipe) . "\nPoints:" . array_shift($recipe) . "\n");
    echo ("Recipe Found with 500 calories:\n" . key($calorie500Recipe) . "\nPoints:" . array_shift($calorie500Recipe) . "\n");
  }

  /**
   * Populate ingredients from the file provided.
   *
   * @param string $filePath
   *
   * @return void
   * @throws Exception
   */
  private function loadIngredients($filePath) {
    $fh = fopen($filePath, 'r');

    if ($fh) {
      $ingredientFactory = new IngredientFactory();

      while (false !== ($line = fgets($fh, 4096))) {
        $ingredient = $ingredientFactory->createIngredient($line);
        $this->ingredients[$ingredient->getName()] = $ingredient;
      }
    } else {
      throw new Exception("Failed to load file: " . $filePath);
    }

    fclose($fh);
  }

  /**
   * Run through all combinations to find the best results.
   *
   * @return array
   */
  private function findBestRecipe()
  {
    $recipe  = [];
    $recipes = [];

    // i = sprinkles
    // j = peanut butter
    // k = frosting
    // h = sugar
    for ($i = 0; $i <= 100; $i++) {
      for ($j = 0; $j <= (100 - $i); $j++) {
        for ($k = 0; $k <= (100 - $i - $j); $k++) {
          $h = 100 - $i - $j - $k;

          if (($capacity = $this->getProperty("capacity", $i, $j, $k, $h)) <= 0) {
            continue;
          }

          if (($durability = $this->getProperty("durability", $i, $j, $k, $h)) <= 0) {
            continue;
          }

          if (($flavor = $this->getProperty("flavor", $i, $j, $k, $h)) <= 0) {
            continue;
          }

          if (($texture = $this->getProperty("texture", $i, $j, $k, $h)) <= 0) {
            continue;
          }

          if (($this->calorie500) && ($this->getProperty("calories", $i, $j, $k, $h) != 500)) {
            continue;
          }

          $label = "Sprinkles: {$i}, Peanut Butter: {$j}, Frosting: {$k}, Sugar: {$h}";
          $recipes[$label] = $capacity * $durability * $flavor * $texture;
        }
      }
    }

    arsort($recipes);
    reset($recipes);

    $recipe[key($recipes)] = array_shift($recipes);

    return $recipe;
  }

  /**
   * Get total of a given property for each of our ingredients.
   *
   * @param string $property
   * @param int    $sprinkles
   * @param int    $peanutButter
   * @param int    $frosting
   * @param int    $sugar
   *
   * @return int
   */
  private function getProperty($property, $sprinkles, $peanutButter, $frosting, $sugar)
  {
    $total          = 0;
    $propertyMethod = "get" . ucfirst($property);

    foreach ($this->ingredients as $name => $ingredient) {
      $multiplier = 0;

      switch ($name) {
        case "Sprinkles":
          $multiplier = $sprinkles;
          break;
        case "PeanutButter":
          $multiplier = $peanutButter;
          break;
        case "Frosting":
          $multiplier = $frosting;
          break;
        case "Sugar":
          $multiplier = $sugar;
          break;
      }

      $total += ($multiplier * $ingredient->$propertyMethod());
    }

    return $total;
  }

}
