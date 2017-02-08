<?php

namespace Macro;

use \JsonSerializable;

class Item implements JsonSerializable
{
    const ERR_BAD_TYPE     = 'The requested type [%s] does not exist on this Item';
    const KCAL_PER_FAT     = 9;
    const KCAL_PER_CARB    = 4;
    const KCAL_PER_PROTEIN = 4;

    protected $name;
    protected $carbs;
    protected $fats;
    protected $proteins;

    /**
     * Constructor
     * @param array $data The data to populate the Item with.
     */
    public function __construct($data = [])
    {
        $this->init($data);
    }

    /**
     * Initialize the Item with data.
     * @param  array $data The data to populate the Item with.
     * @return Macro\Item Returns $this, for possible object-chaining.
     */
    public function init($data = [])
    {
        $defaults = $this->getDefaults();
        $data = array_merge($defaults, $data);
        foreach ($data as $type => $value) {
            $this->$type = $value;
        }
        return $this;
    }

    /**
     * Returns the total caloric quantity of the Item.
     * @return integer The total number of kcals
     */
    public function getCalories()
    {
        return ($this->fats  * self::KCAL_PER_FAT
            + $this->carbs   * self::KCAL_PER_CARB
            + $this->proteins * self::KCAL_PER_PROTEIN
        );
    }

    /**
     * Utility method to get the default props/values for a model instance
     * @return array An array of key/value pairs, all set to default values.
     */
    public function getDefaults()
    {
        return [
            'name'     => '',
            'fats'     => 0,
            'carbs'    => 0,
            'proteins' => 0,
        ];
    }

    /**
     * Utility method to get values of properties on the model.
     * @param  string $type The name of the property to retrieve
     * @return string|integer The value of the property.
     * @throws LogicException If the type isn't available.
     */
    public function get($type)
    {
        $keys = $this->getDefaults();
        if (!array_key_exists($type, $keys)) {
            throw new LogicException(sprintf(self::ERR_BAD_TYPE, $type));
        }
        return $this->$type;
    }

    /**
     * Implementation of the JsonSerializable interface
     * @return array An array of key/value pairs.
     */
    public function jsonSerialize()
    {
        return $this->__toArray();
    }

    /**
     * Letting serialize calls know what properties of this object to store.
     * @return array The properties to store when serializing.
     */
    public function __sleep()
    {
        return [
            'name', 'fats', 'carbs', 'proteins',
        ];
    }

    /**
     * Future proofing this code. Hoping PHP will adopt magic methods for typecasting.
     *
     * @return array An array of key/value pairs.
     */
    public function __toArray()
    {
        return [
            'name'     => $this->name,
            'fats'     => $this->fats,
            'carbs'    => $this->carbs,
            'proteins' => $this->proteins,
        ];
    }
}
