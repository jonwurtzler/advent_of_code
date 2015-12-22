<?php

namespace Advent\WizardSimulator;

class Battle
{
  /**
   * @var array
   */
  private $activeSpells = [];

  /**
   * @var Boss
   */
  private $boss;

  /**
   * @var array
   */
  private $history = [];

  /**
   * @var Wizard
   */
  private $wizard;

  public function __construct()
  {
    $this->boss   = new Boss();
    $this->wizard = new Wizard();
  }

  /**
   * Get the current spells that are active.
   *
   * @return array
   */
  public function getActiveSpells()
  {
    return $this->activeSpells;
  }

  /**
   * Check current spells and clear out expired ones.
   *
   * @return void
   */
  public function newRound()
  {
    foreach ($this->activeSpells as $spellName => $spell) {
      /* @var Spell $spell */
      if ($spell->getDuration() < 1) {
        unset($this->activeSpells[$spellName]);
      } else {
        $spell->newRound();
      }
    }

    // Reset Armor
    $this->wizard->resetArmor();
  }

  /**
   * Cast a spell
   *
   * @param Spell $spell
   *
   * @return bool
   */
  public function castSpell($spell)
  {
    if (!in_array($spell, $this->activeSpells)) {
      $cast = $this->wizard->spendMana($spell);

      if (!$cast) {
        return false;
      }

      $this->activeSpells[$spell->getName()] = $spell;
      $this->history[] = $spell->getName();
    }

    return true;
  }

  /**
   * Go through active spells and deal damage.
   *
   * @return bool
   */
  public function activateSpells()
  {
    foreach ($this->activeSpells as $spellName => $spell) {
      /** @var Spell $spell */

      // Deal Spell Damage
      if ($spell->getDamage() > 0) {
        $alive = $this->boss->takeDamage($spell->getDamage(), false);

        if (!$alive) {
          return false;
        }
      }

      // Apply Armor
      if ($spell->getArmor() > 0) {
        $this->wizard->shield($spell->getArmor());
      }

      // Recharge Mana
      if ($spell->getMana() > 0) {
        $this->wizard->recharge($spell->getMana());
      }

      // Heal HP
      if ($spell->getHealing() > 0) {
        $this->wizard->heal($spell->getHealing());
      }
    }

    return true;
  }

  /**
   * Let the boss deal it's damage.
   *
   * @return bool
   */
  public function dealBossDamage()
  {
    $alive = $this->wizard->takeDamage($this->boss->getDamage());

    if (!$alive) {
      return false;
    }

    return true;
  }

}
