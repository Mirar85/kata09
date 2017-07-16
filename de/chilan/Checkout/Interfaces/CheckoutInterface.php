<?php
/**
 * Created by PhpStorm.
 * User: wohlers
 * Date: 16.07.17
 * Time: 14:24
 */

namespace de\chilan\Checkout\Interfaces;


/**
 * Interface CheckoutInterface
 * Define wich methods must be implemented by a checkout
 * @package de\chilan\Checkout\Interfaces
 */
interface CheckoutInterface
{
    /**
     * Scan a product by the product name
     * @param string $productName
     */
    public function scan($productName);

    /**
     * Return the total prices with all rules
     * @return integer
     */
    public function total();

    /**
     * Return the calculatet prices without the rules
     * @return integer
     */
    public function price();
}