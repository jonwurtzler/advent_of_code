<?php

namespace Advent\Aunt;


class Aunt
{

  /**
   * @var int
   */
  protected $akitas = null;

  /**
   * @var int
   */
  protected $cars = null;

  /**
   * @var int
   */
  protected $cats = null;

  /**
   * @var int
   */
  protected $children = null;

  /**
   * @var int
   */
  protected $goldfish = null;

  /**
   * @var string
   */
  protected $name = null;

  /**
   * @var int
   */
  protected $perfumes = null;

  /**
   * @var int
   */
  protected $pomeranians = null;

  /**
   * @var int
   */
  protected $samoyeds = null;

  /**
   * @var int
   */
  protected $trees = null;

  /**
   * @var int
   */
  protected $vizslas = null;

  /**
   * @return int
   */
  public function getAkitas()
  {
    return $this->akitas;
  }

  /**
   * @return int
   */
  public function getCars()
  {
    return $this->cars;
  }

  /**
   * @return int
   */
  public function getCats()
  {
    return $this->cats;
  }

  /**
   * @return int
   */
  public function getChildren()
  {
    return $this->children;
  }

  /**
   * @return int
   */
  public function getGoldfish()
  {
    return $this->goldfish;
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @return int
   */
  public function getPerfumes()
  {
    return $this->perfumes;
  }

  /**
   * @return int
   */
  public function getPomeranians()
  {
    return $this->pomeranians;
  }

  /**
   * @return int
   */
  public function getSamoyeds()
  {
    return $this->samoyeds;
  }

  /**
   * @return int
   */
  public function getTrees()
  {
    return $this->trees;
  }

  /**
   * @return int
   */
  public function getVizslas()
  {
    return $this->vizslas;
  }

  /**
   * @param int $akitas
   *
   * @return $this
   */
  public function setAkitas($akitas)
  {
    $this->akitas = $akitas;

    return $this;
  }

  /**
   * @param int $cars
   *
   * @return $this
   */
  public function setCars($cars)
  {
    $this->cars = $cars;

    return $this;
  }

  /**
   * @param int $cats
   *
   * @return $this
   */
  public function setCats($cats)
  {
    $this->cats = $cats;

    return $this;
  }

  /**
   * @param int $children
   *
   * @return $this
   */
  public function setChildren($children)
  {
    $this->children = $children;

    return $this;
  }

  /**
   * @param int $goldfish
   *
   * @return $this
   */
  public function setGoldfish($goldfish)
  {
    $this->goldfish = $goldfish;

    return $this;
  }

  /**
   * @param string $name
   *
   * @return $this
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * @param int $perfumes
   *
   * @return $this
   */
  public function setPerfumes($perfumes)
  {
    $this->perfumes = $perfumes;

    return $this;
  }

  /**
   * @param int $pomeranians
   *
   * @return $this
   */
  public function setPomeranians($pomeranians)
  {
    $this->pomeranians = $pomeranians;

    return $this;
  }

  /**
   * @param int $samoyeds
   *
   * @return $this
   */
  public function setSamoyeds($samoyeds)
  {
    $this->samoyeds = $samoyeds;

    return $this;
  }

  /**
   * @param int $trees
   *
   * @return $this
   */
  public function setTrees($trees)
  {
    $this->trees = $trees;

    return $this;
  }

  /**
   * @param int $vizslas
   *
   * @return $this
   */
  public function setVizslas($vizslas)
  {
    $this->vizslas = $vizslas;

    return $this;
  }

}
