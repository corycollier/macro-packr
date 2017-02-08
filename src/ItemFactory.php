<?php

namespace Macro;

use Macro\Item;
use Macro\InputMapper;

class ItemFactory
{
    /**
     * Main method. This takes data and creates an Item from it.
     * @param  string|array $data The data to use to populate the Item with.
     * @return Macro\Item The new Item instance
     */
    public function factory($data)
    {
        $item   = $this->getItem();
        $mapper = $this->getInputMapper();
        $data   = $mapper->map($data);

        $item->init($data);
        return $item;
    }

    /**
     * Returns a new Item instance
     * @return Macro\Item The new Item instance
     */
    public function getItem()
    {
        return new Item;
    }

    /**
     * Returns a new InputMapper instance
     * @return Macro\InputMapper The new InputMapper instance
     */
    public function getInputMapper()
    {
        return new InputMapper;
    }
}
