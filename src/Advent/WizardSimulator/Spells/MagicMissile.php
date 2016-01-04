<?php

namespace Advent\WizardSimulator\Spells;

use Advent\WizardSimulator\Spell;

class MagicMissile extends Spell
{

  public function __construct()
  {
    $this->armor    = 0;
    $this->cost     = 53;
    $this->damage   = 4;
    $this->duration = 0;
    $this->name     = "Magic Missile";
    $this->healing  = 0;
    $this->mana     = 0;
    $this->type     = static::TYPE_INSTANT;
  }

}
