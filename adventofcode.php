<?php
/**
 * Advent of Code 2015 - http://adventofcode.com/
 *
 * Usage: php adventofcode.php
 *
 * @author Jon Wurtzler <jon.wurtzler@gmail.com>
 * @date 12/09/2015
 */

use Advent\StairClimber;
use Advent\WrappingNeeds;
use Advent\SantaDeliveries;

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
}

if (!is_null($adventDay)) {
  $adventDay->display();
} else {
  echo ("Invalid option, please try again\n");
}