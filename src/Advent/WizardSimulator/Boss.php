<?php

namespace Advent\WizardSimulator;

class Boss extends Player
{
  /**
   * @var int
   */
  private $damage = 9;

  public function __construct()
  {
    $this->hp    = 51;
    $this->maxHP = 51;
  }

  /**
   * Boss damage
   *
   * @return int
   */
  public function getDamage()
  {
    return $this->damage;
  }

}
