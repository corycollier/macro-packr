<?php

$items = [
    [   'name'     => 'fat food',
        'fats'     => 20,
        'carbs'    => 5,
        'proteins' => 4,
    ],
    [   'name'     => 'protein food',
        'fats'     => 2,
        'carbs'    => 5,
        'proteins' => 14,
    ],
    [   'name'     => 'carb food',
        'fats'     => 5,
        'carbs'    => 25,
        'proteins' => 8,
    ],
    [   'name'     => 'random 1',
        'fats'     => 0,
        'carbs'    => 25,
        'proteins' => 0,
    ],
    [   'name'     => 'random 2',
        'fats'     => 55,
        'carbs'    => 5,
        'proteins' => 6,
    ],
    [   'name'     => 'random 3',
        'fats'     => 15,
        'carbs'    => 55,
        'proteins' => 18,
    ],
    [   'name'     => 'random 4',
        'fats'     => 15,
        'carbs'    => 25,
        'proteins' => 18,
    ],
];

$max = [
    'carbs'    => '500',
    'proteins' => '300',
    'fats'     => '89',
];

$state = [
    'carbs'    => '134',
    'proteins' => '90',
    'fats'     => '68',
];

require __DIR__ . '/../vendor/autoload.php';

$packer = new Macro\Packr;
// $results = $packer->process($items, $max, $state);
$results = $packer->process($items, $max, $state, Macro\Packr::SORT_CARBS);

print_r($results);
echo PHP_EOL, PHP_EOL;
print_r(json_encode($results));
echo PHP_EOL, PHP_EOL;
print_r(serialize($results));
