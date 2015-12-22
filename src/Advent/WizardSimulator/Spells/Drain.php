<?php

namespace Advent\WizardSimulator\Spells;

use Advent\WizardSimulator\Spell;

class Drain extends Spell
{

  public function __construct()
  {
    $this->armor    = 0;
    $this->cost     = 73;
    $this->damage   = 2;
    $this->duration = 0;
    $this->name     = "Drain";
    $this->healing  = 2;
    $this->mana     = 0;
  }

}
