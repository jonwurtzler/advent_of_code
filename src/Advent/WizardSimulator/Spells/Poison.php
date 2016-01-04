<?php

namespace Advent\WizardSimulator\Spells;

use Advent\WizardSimulator\Spell;

class Poison extends Spell
{

  public function __construct()
  {
    $this->armor    = 0;
    $this->cost     = 173;
    $this->damage   = 3;
    $this->duration = 6;
    $this->name     = "Poison";
    $this->healing  = 0;
    $this->mana     = 0;
    $this->type     = static::TYPE_EFFECT;
  }

}
