<?php

namespace App\Traits;

use Spatie\Enum\Exceptions\UnknownEnumProperty;

trait Headline
{
    /**
     * @return string[]|int[]
     */
    public static function toLabels(): array
    {
        $values = array_keys(static::toArray());
        foreach ($values as $key => $value) {
            $values[$key] = __(
                str($value)->headline()->toString()
            );
        }

        return $values;
    }

    /**
     * @param string $name
     *
     * @throws UnknownEnumProperty
     *
     * @return int|string
     */
    public function __get(string $name)
    {
        if ($name === 'label') {
            return str($this->label)->headline()->toString();
        }

        if ($name === 'value') {
            return $this->value;
        }

        throw UnknownEnumProperty::new(static::class, $name);
    }
}
