<?php

use PHPUnit\Framework\TestCase;
use de\chilan\Checkout\Rules\BuyXPayY;
use de\chilan\Checkout\Rules\BuyXPayOne;
use de\chilan\Checkout\Main\Checkout;

/**
 * Class CheckoutTests
 * Test the Checkout Classes
 */
final class CheckoutTests extends TestCase
{
    private $priceList;

    /**
     * Set up the array list for prices and the autoload function
     */
    public function setUp()
    {
        parent::setUp();
        spl_autoload_register(function ($full_classified_class_name) {
            $path = str_replace('\\','/',$full_classified_class_name);

            if(file_exists($path . '.php'))
            {
                include $path . '.php';
            }
        });

        $this->priceList = [
            'prices' => [
                'A' => 50,
                'B' => 30,
                'C' => 20,
                'D' => 15,
            ],
            'rule' => [
                BuyXPayY::class => [
                    'A' => [
                        'count' => 3,
                        'price' => 130,
                    ],
                    'B' => [
                        'count' => 2,
                        'price' => 45,
                    ],
                ],
            ],
        ];
    }

    /**
     * Test from the Kata http://codekata.com/kata/kata09-back-to-the-checkout/
     * @test
     */
    public function scanItems1Test()
    {
        $rules = new BuyXPayY($this->priceList);

        $co = new Checkout($rules);
        $co->scan('A');
        $this->assertEquals(50,$co->total());
        $co->scan('B');
        $this->assertEquals(80,$co->total());
        $co->scan('A');
        $this->assertEquals(130,$co->total());
        $co->scan('A');
        $this->assertEquals(160,$co->total());
        $co->scan('B');

        $this->assertEquals(210,$co->price());
        $this->assertEquals(175,$co->total());
    }

    /**
     * Longer Test with more scans
     * @test
     */
    public function scanItems2Test()
    {

        $rules = new BuyXPayY($this->priceList);

        $co = new Checkout($rules);
        $co->scan('A');
        $co->scan('B');
        $co->scan('A');
        $co->scan('A');
        $co->scan('B');
        $this->assertEquals(175,$co->total());
        $co->scan('A');
        $this->assertEquals(225,$co->total());
        $co->scan('A');
        $this->assertEquals(275,$co->total());
        $co->scan('A');
        $this->assertEquals(305,$co->total());
        $co->scan('D');
        $this->assertEquals(320,$co->total());
        $co->scan('D');
        $this->assertEquals(335,$co->total());
        $co->scan('A');

        $this->assertEquals(440,$co->price());

        $this->assertEquals(385,$co->total());
    }

    /**
     * Scan many
     * @test
     */
    public function scanManyItemsTest()
    {
        $rules = new BuyXPayY($this->priceList);

        $co = new Checkout($rules);
        for ($i=0;$i<100;$i++) {
            $co->scan('A');
            $co->scan('B');
            $co->scan('C');
            $co->scan('D');
        }

        $this->assertEquals(11500,$co->price());

        $this->assertEquals(10090,$co->total());
    }

    /**
     * Scan with diffrent prices and x for y rules
     * @test
     */
    public function scanWithDiffrentPricesAndManyScansTest()
    {
        $prices = [
            'prices' => [
                'A' => 10,
                'B' => 5,
            ],
            'rule' => [
                BuyXPayY::class => [
                    'A' => [
                        'count' => 100,
                        'price' => 50,
                    ],
                    'B' => [
                        'count' => 200,
                        'price' => 10,
                    ],
                ],
            ],
        ];

        $rules = new BuyXPayY($prices);

        $co = new Checkout($rules);
        for ($i=0;$i<100;$i++) {
            $co->scan('A');
            $co->scan('B');
        }

        $this->assertEquals(1500,$co->price());

        $this->assertEquals(550,$co->total());
    }

    /**
     * Test scan with exchanged rule
     * @test
     */
    public function scanIteamsWithDiffrentRuleSimpleTest()
    {
        $prices = [
            'prices' => [
                'A' => 10,
                'B' => 5,
            ],
            'rule' => [
                BuyXPayOne::class => [
                    'A' => true,
                    'B' => false,
                ],
            ],
        ];

        $rules = new BuyXPayOne($prices);

        $co = new Checkout($rules);
        $co->scan('A');
        $co->scan('A');

        $this->assertEquals(20,$co->price());

        $this->assertEquals(10,$co->total());
    }

    /**
     * Test scan diffrent exchange rule more scans
     * @test
     */
    public function scanIteamsWithDiffrentRuleTest()
    {
        $prices = [
            'prices' => [
                'A' => 10,
                'B' => 5,
            ],
            'rule' => [
                BuyXPayOne::class => [
                    'A' => true,
                    'B' => false,
                ],
            ],
        ];

        $rules = new BuyXPayOne($prices);

        $co = new Checkout($rules);
        for ($i=0;$i<100;$i++) {
            $co->scan('A');
            $co->scan('B');
        }

        $this->assertEquals(1500,$co->price());

        $this->assertEquals(510,$co->total());
    }
}
