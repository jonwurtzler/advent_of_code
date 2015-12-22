<?php

namespace Advent;

use Advent\WizardSimulator\Battle;

class WizardSimulator implements AdventOutputInterface
{
  /**
   * @var Battle[]
   */
  protected $battles = [];

  /**
   * @var int
   */
  protected $lowestMpSpent = 10000;

  /**
   * @var array
   */
  protected $spells = ["Recharge", "Poison", "Shield", "Drain", "MagicMissile"];

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $lowestMana = $this->findLowestMana();
    $spells = "";

    foreach ($lowestMana['spells'] as $spell) {
      $spells .= $spell . "\n";
    }

    echo ("Lowest Mana Battle: \n" .
      "Cost: " . $lowestMana['cost']   . "\n" .
      $spells . "\n\n"
    );
  }

  private function findLowestMana()
  {

  }

  /**
   * Continue a battle.
   *
   * @param Battle $battle
   *
   * @return void
   */
  private function runBattle($battle)
  {


  }

}
