<?php


namespace Support\Traits;


trait Makeable
{
    public static function make(...$arguments)
    {
        if (is_array($arguments)) {
            return new static(...$arguments);
        } else {
            return new static($arguments);
        }

    }
}
