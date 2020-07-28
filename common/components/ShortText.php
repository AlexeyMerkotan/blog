<?php

namespace common\components;

class ShortText
{
    private const NUMBER = 150;

    /**
     * @param string $text
     * @param int $number
     * @return string
     */
    public static function make(string $text, int $number = self::NUMBER): string
    {
        $text = strip_tags($text);
        $text = substr($text, 0, $number);
        $text = rtrim($text, "!,.-");

        return  substr($text, 0, strrpos($text, ' '));
    }
}