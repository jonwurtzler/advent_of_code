<?php

namespace Advent\WizardSimulator;

use Advent\WizardSimulator\Spells\Drain;
use Advent\WizardSimulator\Spells\MagicMissile;
use Advent\WizardSimulator\Spells\Poison;
use Advent\WizardSimulator\Spells\Recharge;
use Advent\WizardSimulator\Spells\Shield;

class Battle
{
  /**
   * @var array
   */
  private $activeSpells = [];

  /**
   * @var array
   */
  private $availableSpells = [];

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

    // Load spells
    $this->availableSpells[] = new Drain();
    $this->availableSpells[] = new MagicMissile();
    $this->availableSpells[] = new Poison();
    $this->availableSpells[] = new Recharge();
    $this->availableSpells[] = new Shield();

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
   * Get all the spells that could be cast.
   *   Determined from those not already active and has the mana to cast.
   *
   * @return bool|array
   */
  public function getAvailableSpells()
  {
    $currentAvailableSpells = [];
    $nonActiveSpells        = array_diff_assoc($this->availableSpells, $this->activeSpells);

    foreach ($nonActiveSpells as $spell) {
      /** @var Spell $spell */
      if ($this->wizard->canCast($spell)) {
        $currentAvailableSpells[] = $spell;
      }
    }

    if (count($currentAvailableSpells) < 1) {
      return false;
    }

    return $currentAvailableSpells;
  }

  /**
   * Return the history of the battle.
   *
   * @return array
   */
  public function getHistory()
  {
    return $this->history;
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
      $this->history[] = $spell;
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
