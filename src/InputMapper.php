<?php

namespace Macro;


class InputMapper
{
    const NAME     = 'name';
    const FATS     = 'fats';
    const CARBS    = 'carbs';
    const PROTEINS = 'proteins';

    public function map($input)
    {
        $result = [];
        $input = $this->jsonDecode($input);
        $input = array_change_key_case($input, CASE_LOWER);

        $map = [
            // name
            self::NAME => self::NAME,
            'title'    => self::NAME,

            // fats
            self::FATS => self::FATS,
            'fat'      => self::FATS,
            'f'        => self::FATS,
            'grasas'   => self::FATS,

            // carbs
            self::CARBS => self::CARBS,
            'carb'      => self::CARBS,
            'c'         => self::CARBS,
            'carbohidratos' => self::CARBS,

            // proteins
            self::PROTEINS => self::PROTEINS,
            'protein'      => self::PROTEINS,
            'p'            => self::PROTEINS,
            'proteínas'    => self::PROTEINS,
        ];

        foreach ($map as $key => $name) {
            if (isset($input[$key])) {
                $result[$name] = $input[$key];
            }
        }

        return $result;
    }

    public function jsonDecode($input)
    {
        if (!$this->isJson($input)) {
            return $input;
        }

        $input = json_decode($input, true);
        return $input;
    }

    public function isJson($input)
    {
        if (!is_string($input)) {
            return false;
        }

        json_decode($input);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
