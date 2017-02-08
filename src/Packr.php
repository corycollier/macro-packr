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

    /**
     * Sorts a list of items, by a given sortBy method.
     * @param array $items The list of items to sort.
     * @param string $sortBy The sorting method.
     * @return array The sorted items.
     */
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

    /**
     * Returns the function to use on an Item, for the provided sort method.
     * @param string $sortBy The sort method.
     * @return string The resulting function to use on the Item.
     */
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

    /**
     * Returns an index value, to use for sorting.
     * @param Item $item The item to get an index value from.
     * @param string $func The function to call on the Item.
     * @param string $sortBy The sorting flag.
     * @param array $results The current list of results.
     * @return string The resulting index value.
     */
    public function getSortIndex($item, $func, $sortBy = self::SORT_CALORIES, $results = [])
    {
        $index = call_user_func_array([$item, $func], [$sortBy]);
        while (array_key_exists((string)$index, $results)) {
            $index = $index + 0.001;
        }
        return (string)$index;
    }

    /**
     * Takes a set of items, and returns the ones that fit in the leftover macro values.
     * @param array $leftovers An associative array of macro leftovers
     * @param Item $item A list of items to filter through.
     * @return array A list of remaining items.
     */
    public function filterByLeftovers($leftovers, $items)
    {
        foreach ($items as $index => $item) {
            if ($this->isOverNumbers($leftovers, $item)) {
                unset($items[$index]);
            }
        }
        return $items;
    }

    /**
     * Calculates if a given item is over the leftover macros for the user.
     * @param array $leftovers An associative array of macro leftovers
     * @param  Item $item  The item to question.
     * @return boolean True if the item has any macro over the current leftovers, false if not.
     */
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
