<?php

namespace Advent\WizardSimulator;

abstract class Player
{

  /**
   * @var int
   */
  protected $armor = 0;

  /**
   * @var int
   */
  protected $hp = 0;

  /**
   * @var int
   */
  protected $maxHP = 100;

  /**
   * Take listed damage.  Return alive state.
   *
   * @param int $damage Full Damage from Boss
   *
   * @return bool
   */
  public function takeDamage($damage, $armor = true)
  {
    $dealtDmg = $damage;

    if ($armor) {
      if (($dealtDmg = ($damage - $this->armor)) < 1) {
        $dealtDmg = 1;
      }
    }

    $this->hp -= $dealtDmg;

    if ($this->hp <= 0) {
      return false;
    }

    return true;
  }

  /**
   * Reset armor from round to round, just add modifiers each round.
   *
   * @return void
   */
  public function resetArmor()
  {
    $this->armor = 0;
  }

}