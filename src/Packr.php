<?php

namespace Macro;

use Macro\ItemFactory;

class Packr
{
    const SORT_CALORIES = 'calories';
    const SORT_CARBS    = 'carbs';
    const SORT_FATS     = 'fats';
    const SORT_PROTEINS = 'proteins';

    /**
     * Calculates the leftover macro amounts from a given set of max data, and a given state of current values.
     * @param array $max An associative array of max macros for the day
     * @param array $state An associative array of current macro values.
     * @return array A resulting associative array of leftover macro values.
     */
    public function getLeftovers($max, $state)
    {
        $results = [];

        foreach ($state as $type => $value) {
            $results[$type] = $max[$type] - $state[$type];
        }
        return $results;
    }


    public function sortItems($items, $sortBy = self::SORT_CALORIES)
    {
        $results = [];
        $func = $this->getSortFunction($sortBy);
        foreach ($items as $item) {
            $index = $this->getSortIndex($item, $func, $sortBy, $results);
            $results[$index] = $item;
        }

        krsort($results);
        return $results;
    }

    public function getSortFunction($sortBy = self::SORT_CALORIES)
    {
        $functionMap = [
            self::SORT_CALORIES => 'getCalories',
            self::SORT_PROTEINS => 'get',
            self::SORT_CARBS    => 'get',
            self::SORT_FATS     => 'get',
        ];
        return $functionMap[$sortBy];
    }

    public function getSortIndex($item, $func, $sortBy = self::SORT_CALORIES, $results = [])
    {
        $index = call_user_func_array([$item, $func], [$sortBy]);
        while (array_key_exists((string)$index, $results)) {
            $index = $index + 0.001;
        }
        return (string)$index;
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

    public function isOverNumbers($leftovers, Item $item)
    {
        $leftovers = (array)$leftovers;

        foreach ($leftovers as $type => $value) {
            if ($item->get($type) > $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * Main entry point to this class. Runs all of the necessary methods to return
     * a list of items filtered and sorted, to best suit the end user's needs.
     * @param array $items A list of items that are available.
     * @param array $max The associative array describing the max macro values.
     * @param array $state The associative array describing the current macro state.
     * @param string $sortBy Sorting preferences (calories/carbs/proteins/fats).
     * @return array The resulting list of Items.
     */
    public function process($items, $max, $state, $sortBy = self::SORT_CALORIES)
    {
        $factory = $this->getItemFactory();
        foreach ($items as $index => $item) {
            $items[$index] = $factory->factory($item);
        }
        $leftovers = $this->getLeftovers($max, $state);
        $sorted = $this->sortItems($items, $sortBy);
        return $this->filterByLeftovers($leftovers, $sorted);
    }

    /**
     * Utility method to get a new ItemFactory instance
     * @return Macro\ItemFactory A new ItemFactory instance
     */
    public function getItemFactory()
    {
        return new ItemFactory;
    }
}
