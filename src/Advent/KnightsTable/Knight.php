<?php namespace Advent\KnightsTable;

class Knight
{

  /**
   * @var string
   */
  protected $name = "";

  /**
   * @var array
   */
  protected $happiness = [];

  /**
   * Knight's Name.
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Knight constructor.
   *
   * @param string $name
   */
  public function __construct($name) {
    $this->name = $name;
  }

  /**
   * Return what happiness rating this knight would have sitting next to the passed one.
   *
   * @param Knight $knight
   *
   * @return bool|int
   */
  public function getHappiness($knight)
  {
    if (array_key_exists($knight->getName(), $this->happiness)) {
      return $this->happiness[$knight->getName()];
    }

    return false;
  }

  /**
   * Set the happiness level if the knight is seated next to the passed Knight.
   *
   * @param string $knightName
   * @param int    $happiness
   */
  public function setHappiness($knightName, $happiness)
  {
    $this->happiness[$knightName] = $happiness;
  }

}
