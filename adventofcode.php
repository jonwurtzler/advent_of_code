<?php
/**
 * Advent of Code 2015 - http://adventofcode.com/
 *
 * Usage: php adventofcode.php
 *
 * @author Jon Wurtzler <jon.wurtzler@gmail.com>
 * @date 12/09/2015
 */

use Advent\AdventCoinMining;
use Advent\AuntSue;
use Advent\ChristmasRPG;
use Advent\CookieRecipe;
use Advent\ElfAccounting;
use Advent\InfiniteElves;
use Advent\LightsAlive;
use Advent\LookAndSay;
use Advent\NaughtyNiceList;
use Advent\ReindeerMedicine;
use Advent\ReindeerOlympics;
use Advent\SantaDeliveries;
use Advent\SantasPassword;
use Advent\StairClimber;
use Advent\TuringLock;
use Advent\WizardSimulator;
use Advent\WrappingNeeds;
use Advent\YardGif;

require_once __DIR__ . '/vendor/autoload.php';

$adventString = (string) isset($argv[1]) ? $argv[1] : "";
$adventDay    = null;

switch ($adventString) {
  case "stair_climber":
    $adventDay = new StairClimber();
    break;
  case "wrapping_needs":
    $adventDay = new WrappingNeeds();
    break;
  case "santa_deliveries":
    $adventDay = new SantaDeliveries();
    break;
  case "coin_mining":
    $adventDay = new AdventCoinMining();
    break;
  case "naughty_and_nice_list":
    $adventDay = new NaughtyNiceList();
    break;
  case "lights_alive":
    $adventDay = new LightsAlive();
    break;
  case "look_and_say":
    $adventDay = new LookAndSay();
    break;
  case "santas_password":
    $adventDay = new SantasPassword();
    break;
  case "elf_accounting":
    $adventDay = new ElfAccounting();
    break;
  case "reindeer_olympics":
    $adventDay = new ReindeerOlympics();
    break;
  case "cookie_recipe":
    $adventDay = new CookieRecipe();
    break;
  case "aunt_sue":
    $adventDay = new AuntSue();
    break;
  case "yard_gif":
    $adventDay = new YardGif();
    break;
  case "reindeer_medicine":
    $adventDay = new ReindeerMedicine();
    break;
  case "infinite_elves":
    $adventDay = new InfiniteElves();
    break;
  case "christmas_rpg":
    $adventDay = new ChristmasRPG();
    break;
  case "wizard_simulator":
    $adventDay = new WizardSimulator();
    break;
  case "turing_lock":
    $adventDay = new TuringLock();
    break;
}

if (!is_null($adventDay)) {
  $adventDay->display();
} else {
  echo ("Invalid option, please try again\n");
}