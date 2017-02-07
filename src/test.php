<?php

$items = [
    [
        'names' => 'fat food',
        'fats' => 20,
        'carbs' => 5,
        'proteins' => 4,
    ],
    [
        'names' => 'protein food',
        'fats' => 2,
        'carbs' => 5,
        'proteins' => 14,
    ],
    [
        'names' => 'carb food',
        'fats' => 5,
        'carbs' => 25,
        'proteins' => 8,
    ],
    [
        'names' => 'random 1',
        'fats' => 0,
        'carbs' => 25,
        'proteins' => 0,
    ],
    [
        'names' => 'random 2',
        'fats' => 55,
        'carbs' => 5,
        'proteins' => 6,
    ],
    [
        'names' => 'random 3',
        'fats' => 15,
        'carbs' => 55,
        'proteins' => 18,
    ],
];

$max = [
    'carbs'    => '500',
    'proteins' => '300',
    'fats'     => '89',
];

$state = [
    'carbs' => '134',
    'proteins' => '90',
    'fats' => '68',
];

require __DIR__ . '/../vendor/autoload.php';

$packer = new MacroPackr\Packer;
$results = $packer->process($items, $max, $state);
print_r($results);
