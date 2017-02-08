<?php

namespace Tests;

use Macro\ItemFactory;

class ItemFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetItem()
    {
        $sut = new ItemFactory;
        $result = $sut->getItem();
        $this->assertInstanceOf('\Macro\Item', $result);
    }
}
