<?php

namespace Tests\ComponentTests;

use Macro\Packr as Packr;
use Macro\Item as Item;

class PackrTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideProcess
     */
    public function testProcess($expected, $items, $max, $state, $sort)
    {
        $sut    = new Packr;
        $result = $sut->process($items, $max, $state, $sort);
        $this->assertEquals($expected, $result);
    }

    public function provideProcess()
    {
        $items    = $this->getDefaultItems();
        $expected = $this->getDefaultExpected();

        return [
            'expect everything to be available' => [
                'expected' => $expected,
                'items'    => $items,
                'max'      => ['fats' => 200, 'carbs' => 1000, 'proteins' => 800],
                'state'    => ['fats' => 0, 'carbs' => 0, 'proteins' => 0],
                'sort'     => Packr::SORT_CALORIES,
            ],

            'simple test (sort by calories)' => [
                'expected' => array_intersect_key($expected, [
                    427 => [],
                    307 => [],
                    216 => [],
                    100 => [],
                    94  => [],
                    177 => [],
                ]),
                'items'    => $items,
                'max'      => ['fats' => 20, 'carbs' => 100, 'proteins' => 80],
                'state'    => ['fats' => 0, 'carbs' => 0, 'proteins' => 0],
                'sort'     => Packr::SORT_CALORIES,
            ],

            'sort by fats' => [
                'expected' => [
                    20       => $expected[216],
                    15       => $expected[427],
                    '15.001' => $expected[307],
                    5        => $expected[177],
                    2        => $expected[94],
                    0        => $expected[100],
                ],
                'items'    => $items,
                'max'      => ['fats' => 20, 'carbs' => 100, 'proteins' => 80],
                'state'    => ['fats' => 0, 'carbs' => 0, 'proteins' => 0],
                'sort'     => Packr::SORT_FATS,
            ],

            'sort by carbs' => [
                'expected' => [
                    55       => $expected[427],
                    '25.002' => $expected[307],
                    '25.001' => $expected[100],
                    25       => $expected[177],
                    5        => $expected[216],
                    '5.001'  => $expected[94],
                ],
                'items'    => $items,
                'max'      => ['fats' => 20, 'carbs' => 100, 'proteins' => 80],
                'state'    => ['fats' => 0, 'carbs' => 0, 'proteins' => 0],
                'sort'     => Packr::SORT_CARBS,
            ],


            'sort by proteins' => [
                'expected' => [
                    '18.001' => $expected[307],
                    18       => $expected[427],
                    14       => $expected[94],
                    8        => $expected[177],
                    4        => $expected[216],
                    0        => $expected[100],
                ],
                'items'    => $items,
                'max'      => ['fats' => 20, 'carbs' => 100, 'proteins' => 80],
                'state'    => ['fats' => 0, 'carbs' => 0, 'proteins' => 0],
                'sort'     => Packr::SORT_PROTEINS,
            ],
        ];
    }

    protected function getDefaultExpected()
    {
        return [
            216 => new Item([
                'name'     => 'fat food',
                'fats'     => 20,
                'carbs'    => 5,
                'proteins' => 4,
            ]),
            177 => new Item([
                'name'     => 'carb food',
                'fats'     => 5,
                'carbs'    => 25,
                'proteins' => 8,
            ]),
            94 => new Item([
                'name'     => 'protein food',
                'fats'     => 2,
                'carbs'    => 5,
                'proteins' => 14,
            ]),
            100 => new Item([
                'name'     => 'random 1',
                'fats'     => 0,
                'carbs'    => 25,
                'proteins' => 0,
            ]),
            539 => new Item([
                'name'     => 'random 2',
                'fats'     => 55,
                'carbs'    => 5,
                'proteins' => 6,
            ]),
            427 => new Item([
                'name'     => 'random 3',
                'fats'     => 15,
                'carbs'    => 55,
                'proteins' => 18,
            ]),
            307 => new Item([
                'name'     => 'random 4',
                'fats'     => 15,
                'carbs'    => 25,
                'proteins' => 18,
            ]),
        ];
    }

    protected function getDefaultItems()
    {
        return [
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
    }
}
