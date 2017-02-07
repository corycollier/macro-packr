<?php

namespace MacroPackr;

class Item
{
    const KCAL_PER_FAT     = 9;
    const KCAL_PER_CARB    = 4;
    const KCAL_PER_PROTEIN = 4;

    protected $carbs;
    protected $fats;
    protected $proteins;

    public function __construct($data = [])
    {
        $this->init();
    }

    public function init($data = [])
    {
        $defaults = $this->getDefaults();
        $data = array_merge($defaults, $data);
        foreach ($data as $type => $value) {
            $this->$type = $value;
        }
    }

    public function getCalories()
    {
        return ($this->fats  * self::KCAL_PER_FAT
            + $this->carbs   * self::KCAL_PER_CARB
            + $this->proteins * self::KCAL_PER_PROTEIN
        );
    }

    public function getDefaults()
    {
        return [
            'fats'     => 0,
            'carbs'    => 0,
            'proteins' => 0,
        ];
    }

    public function __toArray()
    {
        return [
            'fats'     => $this->fats,
            'carbs'    => $this->carbs,
            'proteins' => $this->proteins,
        ];
    }

    public function get($type)
    {
        return $this->$type;
    }
}
