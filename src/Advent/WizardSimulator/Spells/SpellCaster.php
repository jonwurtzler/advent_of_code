<?php

namespace Advent\WizardSimulator\Spells;

use Advent\WizardSimulator\Spell;

class SpellCaster
{
  protected $possibleSpells = ["Poison", "Recharge", "Shield", "Magic Missile", "Drain"];

  /**
   * Return a string value of possible spells to cast.
   *
   * @return array
   */
  public function availableSpells()
  {
    return $this->possibleSpells;
  }

  /**
   * Cast a new version of the spell.
   *
   * @param string $spellName
   *
   * @return Spell|bool
   */
  public function cast($spellName) {
    if (in_array($spellName, $this->possibleSpells)) {
      switch ($spellName) {
        case "Drain":
          return new Drain();
        case "Magic Missile":
          return new MagicMissile();
        case "Poison":
          return new Poison();
        case "Recharge":
          return new Recharge();
        case "Shield":
          return new Shield();
      }
    }

    return false;
  }

}
