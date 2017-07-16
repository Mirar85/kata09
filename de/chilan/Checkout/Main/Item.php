<?php
/**
 * Created by PhpStorm.
 * User: wohlers
 * Date: 16.07.17
 * Time: 14:23
 */

namespace de\chilan\Checkout\Main;

/**
 * Class Item
 * Is an item an represents a prduct with name and price
 * @package de\chilan\Checkout\Main
 */
class Item
{
    /** @var string */
    private $name;

    /** @var  integer */
    private $price;

    /**
     * Item constructor.
     * Needs the name and the price of a item
     * @param string $name
     * @param integer $price
     */
    function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param integer $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


}