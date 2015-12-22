<?php

namespace Advent\WizardSimulator;

abstract class Spell
{

  /**
   * @var int
   */
  protected $armor = 0;

  /**
   * @var int
   */
  protected $cost = 0;

  /**
   * @var int
   */
  protected $damage = 0;

  /**
   * @var int
   */
  protected $duration = 0;

  /**
   * @var int
   */
  protected $healing = 0;

  /**
   * @var int
   */
  protected $mana = 0;

  /**
   * @var string
   */
  protected $name = "";

  /**
   * @return int
   */
  public function getArmor()
  {
    return $this->armor;
  }

  /**
   * @return int
   */
  public function getCost()
  {
    return $this->cost;
  }

  /**
   * @return int
   */
  public function getDamage()
  {
    return $this->damage;
  }

  /**
   * @return int
   */
  public function getDuration()
  {
    return $this->duration;
  }

  /**
   * @return int
   */
  public function getHealing()
  {
    return $this->healing;
  }

  /**
   * @return int
   */
  public function getMana()
  {
    return $this->mana;
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Spend a round of duration.
   *
   * @return $this
   */
  public function newRound()
  {
    $this->duration--;

    return $this;
  }

}
