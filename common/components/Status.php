<?php

namespace common\components;

use Yii;
use BadMethodCallException;

/**
 * Class Status
 * @package common\components
 */
class Status
{
    const NO = 0;
    const YES = 1;

    private static $statuses = [
        self::YES => "Yes",
        self::NO => "No",
    ];

    /**
     * Return array of available statuses
     * @return array
     */
    public static function getStatuses(): array
    {
        return self::$statuses;
    }

    /**
     * Return name for status
     * @param int $status
     * @return string
     * @throws BadMethodCallException when invalid status supplied
     */
    public static function getName(int $status): string
    {
        return self::$statuses[$status];
    }
}
