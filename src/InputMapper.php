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

        if ($this->isSerialized($input)) {
            $input = $this->unSerialize($input);
        }

        if ($this->isJson($input)) {
            $input = $this->jsonDecode($input);
        }

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

    /**
     * Wrapper for the json_decode function
     * @param string $input The json encoded data.
     * @return mixed An object.
     */
    public function jsonDecode($input)
    {
        return json_decode($input, true);
    }

    /**
     * Checks to see if an input is actually json encoded data
     * @param mixed $input Input data.
     * @return boolean True if json encoded data, false if not.
     */
    public function isJson($input)
    {
        if (!is_string($input)) {
            return false;
        }

        json_decode($input);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Unserializes data.
     * @param string $input The serialized data.
     * @return mixed An object.
     */
    public function unSerialize($input)
    {
        return unserialize($input);
    }

    /**
     * Checks to see if an input string is acutally a serialized object.
     * @param mixed $input Input data.
     * @return boolean True if serialized data, false if not.
     */
    public function isSerialized($input)
    {
        if (!is_string($input)) {
            return false;
        }

        return unserialize($input);
    }
}
