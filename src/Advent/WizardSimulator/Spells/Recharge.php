<?php

namespace Advent\WizardSimulator\Spells;

use Advent\WizardSimulator\Spell;

class Recharge extends Spell
{

  public function __construct()
  {
    $this->armor    = 0;
    $this->cost     = 229;
    $this->damage   = 0;
    $this->duration = 5;
    $this->name     = "Recharge";
    $this->healing  = 0;
    $this->mana     = 101;
    $this->type     = static::TYPE_EFFECT;
  }

}
