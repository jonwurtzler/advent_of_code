<?php

namespace Advent;

use Advent\WizardSimulator\Battle;
use Advent\WizardSimulator\Spell;

// First check: 959 (too high) 10,000 battles
// First check: 939 (too high) 10,000 battles
// 900 is the right answer....how...

class WizardSimulator implements AdventOutputInterface
{
  /**
   * @var Battle[]
   */
  protected $battles = [];

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

    $history = "";
    foreach ($this->lowestBattle->getHistory() as $spell) {
      /** @var Spell $spell */
      $history .= "Cost: " . $spell->getCost() . " Spell: " . $spell->getName() . "\n";
    }

    echo ("Lowest Mana Battle: \n" .
      "Cost: " . $this->lowestMpSpent . "\n" .
      $history . "\n\n"
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
    if (!$battle->activateInstantSpell()) {
      return $this->recordBattle($battle);
    }

    /* ------ Boss Round ------ */
    // Setup a new round
    $battle->newRound();

    // Activate Wizard Spells and if boss is still alive
    if (!$battle->activateEffectSpells()) {
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
    // Setup a new round
    $battle->newRound();

    // Activate Wizard Spells and if boss is still alive
    if (!$battle->activateEffectSpells()) {
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
