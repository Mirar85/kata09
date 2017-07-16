<?php
/**
 * Created by PhpStorm.
 * User: wohlers
 * Date: 16.07.17
 * Time: 14:28
 */

namespace de\chilan\Checkout\Rules;


use de\chilan\Checkout\Main\Goods;
use de\chilan\Checkout\Main\Item;

/**
 * Class BuyXPayY
 * The rule that implemented what in Kata http://codekata.com/kata/kata09-back-to-the-checkout/ is written
 * @package de\chilan\Checkout\Rules
 */
class BuyXPayY extends AbstractPriceRules
{
    /** @var  array */
    private $priceTable = [];

    /** @var array  */
    private $specialTable = [];

    /**
     * BuyXPayY constructor.
     * It needs the priceList in the specified array type
     * @param array $priceList
     */
    function __construct(array $priceList)
    {
        $this->priceTable = $priceList['prices'];
        $this->specialTable = $priceList['rule'][self::class];
    }

    /**
     *  Calculate the total prices and use the rule that when there are specified count of items it will cost a given
     * fixed price
     * @param Goods $goods
     * @return int
     */
    public function calculateTotal(Goods $goods)
    {
        $countGoods = [];
        $totalPrice = 0;

        /** @var Item $good */
        foreach ($goods->getItems() as $good) {
            if (!isset($countGoods[$good->getName()])) {
                $countGoods[$good->getName()] = 0;
            }

            $countGoods[$good->getName()]++;
            $totalPrice += $good->getPrice();
            if (isset($this->specialTable[$good->getName()]) && $countGoods[$good->getName()] == $this->specialTable[$good->getName()]['count']) {
                $totalPrice -= $this->specialTable[$good->getName()]['count'] * $good->getPrice();
                $totalPrice += $this->specialTable[$good->getName()]['price'];
                $countGoods[$good->getName()] = 0;
            }
        }
        return $totalPrice;
    }

    /**
     * Parse the product from string product name
     * @param $productName
     * @return Item
     */
    public function parseProductName($productName)
    {
        return new Item($productName,$this->priceTable[$productName]);
    }
}