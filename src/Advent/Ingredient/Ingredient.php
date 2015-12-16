<?php

namespace Advent\Ingredient;

class Ingredient
{

  /**
   * @var int
   */
  protected $calories = 0;

  /**
   * @var int
   */
  protected $capacity = 0;

  /**
   * @var int
   */
  protected $durability = 0;

  /**
   * @var int
   */
  protected $flavor = 0;

  /**
   * @var string
   */
  protected $name = "";

  /**
   * @var int
   */
  protected $texture = 0;

  /**
   * @return int
   */
  public function getCalories()
  {
    return $this->calories;
  }

  /**
   * @return int
   */
  public function getCapacity()
  {
    return $this->capacity;
  }

  /**
   * @return int
   */
  public function getDurability()
  {
    return $this->durability;
  }

  /**
   * @return int
   */
  public function getFlavor()
  {
    return $this->flavor;
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @return int
   */
  public function getTexture()
  {
    return $this->texture;
  }

  /**
   * @param int $calories
   */
  public function setCalories($calories)
  {
    $this->calories = $calories;
  }

  /**
   * @param int $capacity
   */
  public function setCapacity($capacity)
  {
    $this->capacity = $capacity;
  }

  /**
   * @param int $durability
   */
  public function setDurability($durability)
  {
    $this->durability = $durability;
  }

  /**
   * @param int $flavor
   */
  public function setFlavor($flavor)
  {
    $this->flavor = $flavor;
  }

  /**
   * @param string $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
   * @param int $texture
   */
  public function setTexture($texture)
  {
    $this->texture = $texture;
  }

}
