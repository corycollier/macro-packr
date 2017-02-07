<?php

namespace Macro;

use Macro\Item;

class ItemFactory
{
    public function factory($data)
    {
        $item = $this->getItem();
        $item->init($data);
        return $item;
    }

    public function getItem()
    {
        return new Item;
    }
}
