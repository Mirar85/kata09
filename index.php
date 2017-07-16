<?php
/**
 * index.php Only for test case. No realy content at the moment
 */
use de\chilan\Checkout\Rules\BuyXPayY;
use de\chilan\Checkout\Main\Checkout;

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

/** Autoload function for better using the classes */
spl_autoload_register(function ($full_classified_class_name) {
	$path = str_replace('\\','/',$full_classified_class_name);

	if(file_exists($path . '.php'))
        {
    		include $path . '.php';
	}
	else {
		throw new \Exception('Konnte Klasse '.$path.' nicht laden'); 
	}
});

/** @var array $prices - Specified array with the prices and wich rule will be used */
$prices = [
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

/** @var BuyXPayY $rules - Use rule buy x pay y*/
$rules = new BuyXPayY($prices);

/** @var Checkout $co - Initial checkout and play the example drim the Kata */
$co = new Checkout($rules);
echo "<strong>Scan 1 product (A)</strong><br />";
$co->scan('A');
echo "<strong>Scan 2 product (B)</strong><br />";
$co->scan('B');
echo "<strong>Scan 3 product (A)</strong><br />";
$co->scan('A');
echo "<strong>Scan 4 product (A)</strong><br />";
$co->scan('A');
echo "<strong>Scan 5 product (B)</strong><br /><br />";
$co->scan('B');
echo "<strong>The total price is: </strong>";
echo "<strong>".$co->total()."</strong>";