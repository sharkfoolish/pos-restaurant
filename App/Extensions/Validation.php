<?php

namespace App\Extensions;

class Validation
{
    public static function validate($list, $request): void
    {
        foreach ($list as $key => $rules) {
            foreach ($rules as $rule) {
                $rule = explode(':', $rule);
                if (
                    count($rule)<=1 && !Validation::isCorrectDataType($request, $key, $rule)
                    || count($rule)>1 && !Validation::isCorrectDataStatus($request, $key, $rule)
                ){
                    new HttpException(400, '您輸入的資料格式有錯，請確認無誤後再次送出!');
                }
            }
        }
    }

    private static function isCorrectDataType($request, $key, $rule): bool
    {
        return match ($rule[0]) {
            'bool' => is_bool($request[$key]),
            'integer' => is_integer($request[$key]),
            'float' => is_float($request[$key]),
            'string' => is_string($request[$key]),
            'array' => is_array($request[$key]),
            'null' => is_null($request[$key]),
            default => true,
        };
    }

    private static function isCorrectDataStatus($request, $key, $rule): bool
    {
        return match ($rule[0]) {
            'max' => $request[$key] <= $rule[1],
            'min' => $request[$key] >= $rule[1],
            'size' => strlen($request[$key]) == $rule[1],
            'size-min' => strlen($request[$key]) >= $rule[1],
            'size-max' => strlen($request[$key]) <= $rule[1]
        };
    }
}
