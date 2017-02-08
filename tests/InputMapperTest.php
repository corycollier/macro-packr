<?php

namespace Tests;

use Macro\InputMapper;

class InputMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideIsJson
     */
    public function testIsJson($expected, $input)
    {
        $sut = new InputMapper;
        $result = $sut->isJson($input);
        $this->assertEquals($expected, $result);
    }

    public function provideIsJson()
    {
        return [
            [
                'expected' => true,
                'input' => json_encode((object)['key' => 'val']),
            ],
        ];
    }
}
