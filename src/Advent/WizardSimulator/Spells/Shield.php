<?php

namespace Advent\WizardSimulator\Spells;

use Advent\WizardSimulator\Spell;

class Shield extends Spell
{

  public function __construct()
  {
    $this->armor    = 7;
    $this->cost     = 113;
    $this->damage   = 0;
    $this->duration = 6;
    $this->name     = "Shield";
    $this->healing  = 0;
    $this->mana     = 0;
    $this->type     = static::TYPE_EFFECT;
  }

}
