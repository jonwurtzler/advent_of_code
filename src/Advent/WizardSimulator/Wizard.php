<?php

namespace Advent\WizardSimulator;

class Wizard extends Player
{

  /**
   * @var int
   */
  private $mp = 500;

  /**
   * @var int
   */
  private $maxMP = 500;

  public function __construct()
  {
    $this->hp    = 50;
    $this->maxHP = 50;
  }

  /**
   * Determine if the wizard can cast the given spell with it's current mana.
   *
   * @param Spell $spell
   *
   * @return bool
   */
  public function canCast($spell)
  {
    if ($spell->getCost() <= $this->mp) {
      return true;
    }

    return false;
  }

  /**
   * Spend mana for a spell
   *
   * @param Spell $spell
   *
   * @return bool
   */
  public function spendMana($spell)
  {
    $this->mp -= $spell->getCost();

    if ($this->mp <= 0) {
      return false;
    }

    return true;
  }

  /**
   * Heal HP damage up to max
   *
   * @param int $hp
   *
   * @return void
   */
  public function heal($hp)
  {
    $this->hp += $hp;

    if ($this->hp > $this->maxHP) {
      $this->hp = $this->maxHP;
    }
  }

  /**
   * Recharge MP points up to max
   *
   * @param int $mp
   *
   * @return void
   */
  public function recharge($mp)
  {
    $this->mp += $mp;

    if ($this->mp > $this->maxMP) {
      $this->mp = $this->maxMP;
    }
  }

  /**
   * Set Armor value.
   *
   * @param $armor
   *
   * @return void
   */
  public function shield($armor)
  {
    $this->armor += $armor;
  }

}