<?php

namespace Advent;

class ChristmasRPG implements AdventOutputInterface
{
  /**
   * @var array
   */
  private $armors  = [
    "Loincloth"   => ["cost" => 0,   "armor" => 0, "damage" => 0],
    "Leather"     => ["cost" => 13,  "armor" => 1, "damage" => 0],
    "Chainmail"   => ["cost" => 31,  "armor" => 2, "damage" => 0],
    "Splintmail"  => ["cost" => 53,  "armor" => 3, "damage" => 0],
    "Bandedmail"  => ["cost" => 75,  "armor" => 4, "damage" => 0],
    "Platemail"   => ["cost" => 102, "armor" => 5, "damage" => 0]
  ];

  /**
   * @var array
   */
  private $enemy = [
    "hp"     => 104,
    "armor"  => 1,
    "damage" => 8
  ];

  /**
   * @var array
   */
  private $rings   = [
    "No Ring"     => ["cost" => 0,   "armor" => 0, "damage" => 0],
    "Damage +1"   => ["cost" => 25,  "armor" => 0, "damage" => 1],
    "Damage +2"   => ["cost" => 50,  "armor" => 0, "damage" => 2],
    "Damage +3"   => ["cost" => 100, "armor" => 0, "damage" => 3],
    "Defense +1"  => ["cost" => 20,  "armor" => 1, "damage" => 0],
    "Defense +2"  => ["cost" => 40,  "armor" => 2, "damage" => 0],
    "Defense +3"  => ["cost" => 80,  "armor" => 3, "damage" => 0],
  ];

  /**
   * @var array
   */
  private $weapons = [
    "Dagger"     => ["cost" => 8,  "armor" => 0, "damage" => 4],
    "Shortsword" => ["cost" => 10, "armor" => 0, "damage" => 5],
    "Warhammer"  => ["cost" => 25, "armor" => 0, "damage" => 6],
    "Longsword"  => ["cost" => 40, "armor" => 0, "damage" => 7],
    "Greataxe"   => ["cost" => 74, "armor" => 0, "damage" => 8]
  ];

  /**
   * Display the Advent Day's work.
   *
   * @return mixed
   */
  public function display()
  {
    $friendlyShopkeeper = $this->findEquipment();
    $corruptShopkeeper  = $this->findEquipment(true);

    echo ("Friendly Shopkeeper Gear: \n" .
      "Cost:   " . $friendlyShopkeeper['cost']   . "\n"   .
      "Weapon: " . $friendlyShopkeeper['weapon'] . "\n"   .
      "Armor:  " . $friendlyShopkeeper['armor']  . "\n"   .
      "Ring 1: " . $friendlyShopkeeper['ring_1'] . "\n"   .
      "Ring 2: " . $friendlyShopkeeper['ring_2'] . "\n\n"
    );

    echo ("Corrupt Shopkeeper Gear: \n" .
      "Cost:   " . $corruptShopkeeper['cost']   . "\n"   .
      "Weapon: " . $corruptShopkeeper['weapon'] . "\n"   .
      "Armor:  " . $corruptShopkeeper['armor']  . "\n"   .
      "Ring 1: " . $corruptShopkeeper['ring_1'] . "\n"   .
      "Ring 2: " . $corruptShopkeeper['ring_2'] . "\n"
    );
  }

  /**
   * Find lowest amount spent to win battle.
   *
   * @return array
   */
  private function findEquipment($corruptShopkeeper = false)
  {
    $failedSets     = [];
    $leftHand       = $this->rings;
    $rightHand      = $this->rings;
    $successfulSets = [];

    foreach ($this->weapons as $weapon => $weaponStats) {
      foreach ($this->armors as $armor => $armorStats) {
        foreach ($rightHand as $rightHandRing => $rightHandStats) {
          foreach ($leftHand as $leftHandRing => $leftHandStats) {
            if (($rightHandRing != "No Ring") && ($rightHandRing === $leftHandRing)) {
              continue;
            }

            $stats = $this->calculateStats($weaponStats, $armorStats, $rightHandStats, $leftHandStats);
            $battleResults = $this->runBattle($stats);

            if ($battleResults) {
              $successfulSets[$stats['cost']] = [
                "cost"   => $stats['cost'],
                "weapon" => $weapon,
                "armor"  => $armor,
                "ring_1" => $rightHandRing,
                "ring_2" => $leftHandRing
              ];
            } else {
              $failedSets[$stats['cost']] = [
                "cost"   => $stats['cost'],
                "weapon" => $weapon,
                "armor"  => $armor,
                "ring_1" => $rightHandRing,
                "ring_2" => $leftHandRing
              ];
            }
          }
        }
      }
    }

    sort($successfulSets);
    rsort($failedSets);

    if ($corruptShopkeeper) {
      return $failedSets[0];
    }

    return $successfulSets[0];
  }

  /**
   * Get total armor/attack/costs for running a battle.
   *
   * @param array $weaponStats
   * @param array $armorStats
   * @param array $rightHandRingStats
   * @param array $leftHandRingStats
   *
   * @return array
   */
  private function calculateStats($weaponStats, $armorStats, $rightHandRingStats, $leftHandRingStats)
  {
    $stats = [
      'armor'  => 0,
      'damage' => 0,
      'cost'   => 0
    ];

    foreach ($stats as $stat => $value) {
      $stats[$stat] =
        $weaponStats[$stat]
        + $armorStats[$stat]
        + $rightHandRingStats[$stat]
        + $leftHandRingStats[$stat];
    }

    return $stats;
  }

  /**
   * Run through the battle with the given equipment.
   *
   * @param array $hero
   *
   * @return bool
   */
  private function runBattle($hero)
  {
    $heroHP  = 100;
    $enemyHP = $this->enemy['hp'];

    $win = false;

    do {
      if(($heroDmg = $hero['damage'] - $this->enemy['armor']) <= 0) {
        $heroDmg = 1;
      }

      if (($enemyHP -= $heroDmg) <= 0) {
        $win = true;
        break;
      }

      if(($enemyDmg = $this->enemy['damage'] - $hero['armor']) <= 0) {
        $enemyDmg = 1;
      }

      $heroHP  -= $enemyDmg;
    } while (($heroHP > 0) && ($enemyHP > 0));

    return $win;
  }

}
