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

  /**
   * @var Battle
   */
  protected $lowestBattle;

  /**
   * @var int
   */
  protected $lowestMpSpent = 10000;

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $this->runBattle(new Battle());
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
   * Continue a battle.
   *
   * @param Battle $battle
   * @param Spell  $nextSpell
   */
  private function runBattle($battle, $nextSpell = null)
  {
    // Setup a new round
    $battle->newRound();

    // Cast next spell
    $availableSpells = $battle->getAvailableSpells();

    if (is_null($nextSpell)) {
      $nextSpell = array_shift($availableSpells);
    }

    $battle->castSpell($nextSpell);

    // Activate Wizard Spells and check if boss is still alive
    if (!$battle->activateSpells()) {

    }

  }

}
