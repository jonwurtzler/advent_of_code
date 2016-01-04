<?php

namespace Advent\WizardSimulator;

use Advent\WizardSimulator\Spells\SpellCaster;

class Battle
{
  /**
   * @var array
   */
  private $activeEffectSpells = [];

  /**
   * @var Spell
   */
  private $activeInstantSpell = null;

  /**
   * @var int
   */
  private $battleCost = 0;

  /**
   * @var Boss
   */
  private $boss;

  /**
   * @var array
   */
  private $history = [];

  /**
   * @var SpellCaster
   */
  private $spellCaster;

  /**
   * @var Wizard
   */
  private $wizard;

  public function __construct()
  {
    $this->boss        = new Boss();
    $this->spellCaster = new SpellCaster();
    $this->wizard      = new Wizard();
  }

  function __clone()
  {
    $this->boss   = clone $this->boss;
    $this->wizard = clone $this->wizard;

    foreach ($this->activeEffectSpells as $spellName => $spell) {
      $this->activeEffectSpells[$spellName] = clone $spell;
    }
  }

  /**
   * Get the current effect spells that are active.
   *
   * @return array
   */
  public function getActiveEffectSpells()
  {
    return $this->activeEffectSpells;
  }

  /**
   * Check current spells and clear out expired ones.
   *
   * @return void
   */
  public function newRound()
  {
    // Reset Armor
    $this->wizard->resetArmor();

    // Run through spell list and clear out old spells
    foreach ($this->activeEffectSpells as $spellName => $spell) {
      /* @var Spell $spell */
      $spell->newRound();

      if ($spell->getDuration() < 1) {
        unset($this->activeEffectSpells[$spellName]);
      }
    }
  }

  /**
   * Get all the spells that could be cast.
   *   Determined from those not already active and has the mana to cast.
   *
   * @return bool|array
   */
  public function getAvailableSpells()
  {
    $availableSpells = [];
    $nonActiveSpells = array_diff_assoc($this->spellCaster->availableSpells(), array_keys($this->activeEffectSpells));

    foreach ($nonActiveSpells as $spellName) {
      $spell = $this->spellCaster->cast($spellName);
      if ($this->wizard->canCast($spell)) {
        $availableSpells[] = $spell;
      }
    }

    if (count($availableSpells) < 1) {
      return false;
    }

    return $availableSpells;
  }

  /**
   * Get a total of MP spent in this battle.
   *
   * @return int
   */
  public function getBattleCost()
  {
    return $this->battleCost;
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
   * @return void
   */
  public function castSpell($spell)
  {
    $this->wizard->spendMana($spell);

    $castSpell = $this->spellCaster->cast($spell->getName());

    if ($spell->isInstant()) {
      $this->activeInstantSpell = $castSpell;
    } else {
      $this->activeEffectSpells[$spell->getName()] = $castSpell;
    }


    $this->battleCost += $spell->getCost();
    $this->history[] = $castSpell;
  }

  /**
   * Go through active spells and deal damage.
   *
   * @return bool
   */
  public function activateEffectSpells()
  {
    foreach ($this->activeEffectSpells as $spellName => $spell) {
      /** @var Spell $spell */

      // Deal Spell Damage
      if ($spell->getDamage() > 0) {
        $alive = $this->boss->takeDamage($spell->getDamage(), false);

        if (!$alive) {
          return false;
        }
      }

      // Apply Armor if Spell has armor value
      if ($spell->getArmor() > 0) {
        $this->wizard->shield($spell->getArmor());
      }

      // Recharge Mana if Spell has mana value
      if ($spell->getMana() > 0) {
        $this->wizard->recharge($spell->getMana());
      }
    }

    return true;
  }

  /**
   * Trigger any instant spells that need to be run.
   *   Current possible spells: Drain, Magic Missile
   *
   * @return bool
   */
  public function activateInstantSpell()
  {
    if (!is_null($this->activeInstantSpell)) {
      $spell = $this->activeInstantSpell;
      $this->activeInstantSpell = null;

      // Deal Spell Damage
      if ($spell->getDamage() > 0) {
        if (!$this->boss->takeDamage($spell->getDamage(), false)) {
          return false;
        }
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
