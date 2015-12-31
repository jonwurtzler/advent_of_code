<?php

namespace Advent;

use Advent\WizardSimulator\Battle;
use Advent\WizardSimulator\Spell;

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
  protected $lowestMpSpent = 10000;

  protected $maxBattles = 30000;

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
    $battleCost      = $battle->getBattleMPCost();
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
  private function runBattle($battle, $nextSpell = null)
  {
    if (count($battle->getHistory()) > 10) { return false; }
    if ($this->battleNumber > $this->maxBattles) { return false; }

    // Setup a new round
    $battle->newRound();

    // Cast next spell
    $battle->castSpell($nextSpell);

    // Activate wizard spells
    $bossAlive = $battle->activateSpells();

    // Check if boss is still alive
    if (!$bossAlive) {
      return $this->recordBattle($battle);
    }

    // Deal boss damage if still alive
    $wizardAlive = $battle->dealBossDamage();

    // Check if wizard is still alive.
    if (!$wizardAlive) {
      return false;
    }

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
    $spells = $battle->getAvailableSpells();

    if ($spells) {
      foreach ($spells as $spell) {
        // Make a branch of this battle to run through next spells with.
        $battleBranch = clone $battle;
        //$this->currentBattles[] = $battleBranch;
        $this->battleNumber++;

        $this->runBattle($battleBranch, $spell);
      }
    }

    return true;
  }

  // First check: 959 (too high) 10,000 battles
  // First check: 939 (too high) 10,000 battles

}
