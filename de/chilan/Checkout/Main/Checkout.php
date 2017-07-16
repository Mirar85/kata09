<?php
/**
 * Created by PhpStorm.
 * User: wohlers
 * Date: 16.07.17
 * Time: 14:24
 */

namespace de\chilan\Checkout\Main;


use de\chilan\Checkout\Interfaces\CheckoutInterface;
use de\chilan\Checkout\Rules\AbstractPriceRules;

class Checkout implements CheckoutInterface
{
    /** @var  Goods */
    private $goods;

    /** @var  AbstractPriceRules */
    private $priceRule;

    /**
     * Checkout constructor.
     * Use dependency inection, so that diffrend rules can be used
     * @param AbstractPriceRules $priceListAndRule
     */
    function __construct(AbstractPriceRules $priceListAndRule)
    {
        $this->priceRule = $priceListAndRule;
        $this->total = 0;
        $this->goods = new Goods();
    }

    /**
     * Scan a product and put it to the goods list as a item
     * @param string $productName
     */
    public function scan($productName)
    {
        $item = $this->priceRule->parseProductName($productName);
        $this->goods->addItem($item);
    }

    /**
     * Return the overall prices for all products without rules
     * @return integer
     */
    public function price()
    {
        $priceWithoutRule = 0;
        /** @var Item $good */
        foreach ($this->goods->getItems() as $good) {
            $priceWithoutRule += $good->getPrice();
        }
        return $priceWithoutRule;
    }

    /**
     * Return the total sum of all products with rule in the price list
     * @return integer
     */
    public function total()
    {
        return $this->priceRule->calculateTotal($this->goods);
    }
}