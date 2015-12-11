<?php

use Advent\AdventCoinMining;

class AdventCoinMiningTest extends PHPUnit_Framework_TestCase
{

  // TC comes from the website examples. (TC = Test Case)
  public function testWrappingNeedsTC1()
  {
    $adventMining = new AdventCoinMining();
    $this->assertEquals(609043, $adventMining->hackAdventCoinHashes("abcdef", 5));
  }

  public function testWrappingNeedsTC2()
  {
    $adventMining = new AdventCoinMining();
    $this->assertEquals(1048970, $adventMining->hackAdventCoinHashes("pqrstuv", 5));
  }

  /**
   * @expectedException Exception
   */
  public function testInvalidZeroStringNumber() {
    $adventMining = new AdventCoinMining();
    $adventMining->hackAdventCoinHashes("abcdef", -5);
  }

}
