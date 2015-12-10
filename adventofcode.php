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

require_once __DIR__ . '/vendor/autoload.php';

$adventString = (string) isset($argv[1]) ? $argv[1] : "";
$adventDay    = null;

switch ($adventString) {
  case "stair_climber":
    $adventDay = new StairClimber();
    break;
}

if (!is_null($adventDay)) {
  $adventDay->display();
}