<?php

namespace Tests;

use Macro\Packr;

class PackrTest extends \PHPUnit_Framework_TestCase
{
    public function testGetItemFactory()
    {
        $sut = new Packr;
        $result = $sut->getItemFactory();
        $this->assertInstanceOf('\Macro\ItemFactory', $result);
    }
}
