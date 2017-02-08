<?php

namespace Tests\UnitTests;

use Macro\Item;

class ItemTest extends \PHPUnit_Framework_TestCase
{

    public function testGetDefaults()
    {
        $expected = [
            'name'     => '',
            'fats'     => 0,
            'carbs'    => 0,
            'proteins' => 0,
        ];

        $sut = new Item;
        $result = $sut->getDefaults();
        $this->assertEquals($expected, $result);

    }
}
