<?php

$items = [
    [
        'name' => 'fat food',
        'fat' => 20,
        'carb' => 5,
        'protein' => 4,
    ],
    [
        'name' => 'protein food',
        'fat' => 2,
        'carb' => 5,
        'protein' => 14,
    ],
    [
        'name' => 'carb food',
        'fat' => 5,
        'carb' => 25,
        'protein' => 8,
    ],
    [
        'name' => 'random 1',
        'fat' => 0,
        'carb' => 25,
        'protein' => 0,
    ],
    [
        'name' => 'random 2',
        'fat' => 55,
        'carb' => 5,
        'protein' => 6,
    ],
    [
        'name' => 'random 3',
        'fat' => 15,
        'carb' => 55,
        'protein' => 18,
    ],
];

$max = [
    'carb'    => '500',
    'protein' => '300',
    'fat'     => '89',
];

$state = [
    'carb' => '134',
    'protein' => '90',
    'fat' => '68',
];


// determine numbers remaining
function get_leftovers($max, $state) {
    $results = [];

    foreach ($state as $type => $value) {
        $results[$type] = $max[$type] - $state[$type];
    }
    return $results;
}

function sort_items($items) {
    $results = [];
    foreach ($items as $item) {
        $calories = get_calories($item);
        $results[$calories] = $item;
    }

    krsort($results);

    return $results;
}

function get_calories($item) {
    $defaults = [
        'fat' => 0,
        'protein' => 0,
        'carbs' => 0,
    ];

    $item = array_merge($defaults, $item);

    return ($item['fat'] * 9
        + $item['carbs'] * 4
        + $item['protein'] * 4
    );
}

function filter_by_leftovers($leftovers, $items) {
    foreach ($items as $index => $item) {
        if (is_over_numbers($leftovers, $item)) {
            unset($items[$index]);
            echo 'found one', $item['name'], PHP_EOL;
        }
    }
    return $items;
}

function is_over_numbers($leftovers, $item) {
    foreach ($leftovers as $type => $value) {
        if ($item[$type] > $value) {
            return true;
        }
    }

    return false;
}

$leftovers = get_leftovers($max, $state);

$sorted = sort_items($items);

$filtered = filter_by_leftovers($leftovers, $sorted);

print_r($filtered);
