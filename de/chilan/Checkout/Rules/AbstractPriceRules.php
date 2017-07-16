<?php
/**
 * Created by PhpStorm.
 * User: wohlers
 * Date: 16.07.17
 * Time: 14:29
 */

namespace de\chilan\Checkout\Rules;


use de\chilan\Checkout\Main\Goods;

/**
 * Class AbstractPriceRules
 * An abstract class for the price rules, so that there can be many diffrent rules
 * To combine more rules there can be build a class from this type that will use the diffrent rules inside, so that
 * one rule can have more other rules inside
 * @package de\chilan\Checkout\Rules
 */
abstract class AbstractPriceRules
{
    /**
     * This method is for calculating the total prices with all rules
     * @param Goods $goods
     * @return mixed
     */
    public abstract function calculateTotal(Goods $goods);

    /**
     * Parse a product name in an item object. Properly needed for some rules to inflent this
     * @param $productName
     * @return mixed
     */
    public abstract function parseProductName($productName);
}