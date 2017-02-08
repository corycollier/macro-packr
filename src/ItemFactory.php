<?php

namespace Macro;

use Macro\Item;

class ItemFactory
{
    public function factory($data)
    {
        $item   = $this->getItem();
        $mapper = $this->getInputMapper();
        $data   = $mapper->map($data);

        $item->init($data);
        return $item;
    }

    public function getItem()
    {
        return new Item;
    }

    public function getInputMapper()
    {
        return new InputMapper;
    }
}
