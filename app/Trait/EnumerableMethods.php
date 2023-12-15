<?php

namespace App\Trait;

trait EnumerableMethods
{
    public static function getItem($enum): array
    {
        return [$enum->name => $enum->value];
    }

    public static function getAll(): array
    {
        $res = [];
        foreach (self::cases() as $case) {
            $res = array_merge($res, self::getItem($case));
        }

        return $res;
    }

    public static function getAllCaseValues(): array
    {
        $res = [];
        foreach (self::cases() as $case) {
            $res = array_merge($res, [$case->value => $case->value]);
        }

        return $res;
    }
}
