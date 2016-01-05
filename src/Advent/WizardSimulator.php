<?php

namespace Advent;

use Advent\WizardSimulator\Battle;
use Advent\WizardSimulator\Spell;

// First check: 959 (too high) 10,000 battles
// First check: 939 (too high) 10,000 battles
// 900 is the right answer....how...
// Finally got to 900.  Found that I was not handling the rounds correctly or how spells were being removed and cast.
/*
 * NM Lowest Mana Battle:
 * Cost: 900
 * Cost: 173 Spell: Poison
 * Cost: 229 Spell: Recharge
 * Cost: 113 Spell: Shield
 * Cost: 173 Spell: Poison
 * Cost: 53 Spell: Magic Missile
 * Cost: 53 Spell: Magic Missile
 * Cost: 53 Spell: Magic Missile
 * Cost: 53 Spell: Magic Missile
 *
 * HM Lowest Mana Battle:
 * Cost: 1216
 * Cost: 173 Spell: Poison
 * Cost: 229 Spell: Recharge
 * Cost: 113 Spell: Shield
 * Cost: 173 Spell: Poison
 * Cost: 229 Spell: Recharge
 * Cost: 73 Spell: Drain
 * Cost: 173 Spell: Poison
 * Cost: 53 Spell: Magic Missile
 */

class WizardSimulator implements AdventOutputInterface
{
  /**
   * @var Battle[]
   */
  protected $battles = [];

  /**
   * @var int
   */
  protected $battleNumber = 0;

  /**
   * @var Battle
   */
  protected $lowestBattle;

  /**
   * @var int
   */
  protected $lowestMpSpent = 1100;

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $this->spellHandler(new Battle());

    $nmCost    = "Cost: " . $this->lowestMpSpent;
    $nmHistory = "";
    foreach ($this->lowestBattle->getHistory() as $spell) {
      /** @var Spell $spell */
      $nmHistory .= "Cost: " . $spell->getCost() . " Spell: " . $spell->getName() . "\n";
    }

    echo (
      "NM Lowest Mana Battle: \n" .
      $nmCost . "\n" .
      $nmHistory . "\n\n"
    );

    // Reset for HM
    $this->lowestBattle  = null;
    $this->lowestMpSpent = 1500;
    $this->spellHandler(new Battle(true));

    $hmCost    = "Cost: " . $this->lowestMpSpent;
    $hmHistory = "";
    foreach ($this->lowestBattle->getHistory() as $spell) {
      /** @var Spell $spell */
      $hmHistory .= "Cost: " . $spell->getCost() . " Spell: " . $spell->getName() . "\n";
    }

    echo (
      "HM Lowest Mana Battle: \n" .
      $hmCost . "\n" .
      $hmHistory . "\n\n"
    );
  }

  /**
   * Check if won battle is the lowest MP spent.
   *   Record the battle as well.
   *
   * @param Battle $battle
   *
   * @return bool
   */
  private function recordBattle($battle)
  {
    $battleCost      = $battle->getBattleCost();
    $this->battles[] = $battle;

    if ($battleCost < $this->lowestMpSpent) {
      $this->lowestBattle  = $battle;
      $this->lowestMpSpent = $battleCost;
    }

    return true;
  }

  /**
   * Continue a battle.
   *
   * @param Battle $battle
   * @param Spell  $nextSpell
   *
   * @return bool
   */
  private function runBattle($battle, $nextSpell)
  {
    /* ----- Wizard Round ----- */
    // Cast next spell
    $battle->castSpell($nextSpell);

    // Run any instant spells
    if ($battle->activateInstantSpell()) {
      return $this->recordBattle($battle);
    }

    /* ------ Boss Round ------ */
    // Activate Wizard Spells and if boss is still alive
    if ($battle->activateEffectSpells()) {
      return $this->recordBattle($battle);
    }

    // Deal Boss dmg and check if wizard is still alive
    if (!$battle->dealBossDamage()) {
      return false;
    }

    // Both still alive, continue to next rounds.
    return $this->spellHandler($battle);
  }

  /**
   * Cycle through available spells to get the branches of battle.
   *
   * @param Battle $battle
   *
   * @return bool
   */
  private function spellHandler($battle)
  {
    // Check for Hard Mode.
    if(!$battle->hardMode()) {
      return false;
    }

    // Activate Wizard Spells and if boss is still alive
    if ($battle->activateEffectSpells()) {
      return $this->recordBattle($battle);
    }

    // Get possible spells for this round
    $spells = $battle->getAvailableSpells();

    // If there are spells available, the battle can continue
    if ($spells) {
      foreach ($spells as $spell) {
        /** @var Spell $spell */
        // Skip to the next spell if it would bring the total cost higher than the current lowest
        if (($battle->getBattleCost() + $spell->getCost()) > $this->lowestMpSpent) { continue; }

        // Make a branch of this battle to run through next spells with.
        $battleBranch = clone $battle;

        $this->battleNumber++;

        $this->runBattle($battleBranch, $spell);
      }

      return true;
    }

    return false;
  }

}
