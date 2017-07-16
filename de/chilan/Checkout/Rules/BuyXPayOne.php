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
 * Class BuyXPayOne
 * A properly sinless rule. For the given products that set to use this rule there will be only pay one item and can
 * have as much as there want. This rule is only implemented to show that is easy to switch the rules. Only one new
 * class of the AbstractPriceRules must be written
 * @package de\chilan\Checkout\Rules0
 */
class BuyXPayOne extends AbstractPriceRules
{
    /** @var  array */
    private $priceTable = [];

    /** @var array  */
    private $specialTable = [];

    /**
     * BuyXPayOne constructor.
     * It needs the priceList in the specified array type
     * @param array $priceList
     */
    function __construct(array $priceList)
    {
        $this->priceTable = $priceList['prices'];
        $this->specialTable = $priceList['rule'][self::class];
    }

    /**
     * Calculate the total prices and use the rule that when there a product is set to use the rule it must only
     * paye one of the items
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
                $countGoods[$good->getName()] = true;
            }

            /** Only the first time for the rule go in here */
            if ($countGoods[$good->getName()] === true)
                if (isset($this->specialTable[$good->getName()]) && $this->specialTable[$good->getName()] === true) {
                    $countGoods[$good->getName()] = false;
                    $totalPrice += $good->getPrice();
                } else {
                    $totalPrice += $good->getPrice();
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