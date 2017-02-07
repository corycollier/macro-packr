<?php

namespace MacroPackr;

use MacroPackr\ItemFactory;

class Packer
{
    protected $itemFactory;

    public function __construct()
    {
        $this->itemFactory = new ItemFactory;
    }

    public function getLeftovers($max, $state)
    {
        $results = [];

        foreach ($state as $type => $value) {
            $results[$type] = $max[$type] - $state[$type];
        }
        return $results;
    }

    public function sortItems($items)
    {
        $results = [];
        foreach ($items as $item) {
            $calories = $item->getCalories();
            $results[$calories] = $item;
        }

        krsort($results);
        return $results;
    }

    public function filterByLeftovers($leftovers, $items)
    {
        foreach ($items as $index => $item) {
            if ($this->isOverNumbers($leftovers, $item)) {
                unset($items[$index]);
            }
        }
        return $items;
    }

    public function isOverNumbers($leftovers, $item)
    {
        $leftovers = (array)$leftovers;

        foreach ($leftovers as $type => $value) {
            if ($item->get($type) > $value) {
                return true;
            }
        }

        return false;
    }

    public function process($items, $max, $state)
    {
        foreach ($items as $index => $item) {
            $items[$index] = $this->itemFactory->factory($item);
        }
        $leftovers = $this->getLeftovers($max, $state);
        $sorted = $this->sortItems($items);
        return $this->filterByLeftovers($leftovers, $sorted);
    }
}