<?php
/**
 * Created by PhpStorm.
 * User: wohlers
 * Date: 16.07.17
 * Time: 14:24
 */

namespace de\chilan\Checkout\Main;

/**
 * Class Goods
 * Represents a list of products (Item)
 * @package de\chilan\Checkout\Main
 */
class Goods
{
    /** @var  array */
    private $items;

    function __construct()
    {
        $this->items = [];
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    public function addItem($item)
    {
        $this->items[] = $item;
    }
}