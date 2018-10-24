<?php

namespace Endeavors\Components\Encryption;

final class Crypt
{
    public static function asObject($key = "")
    {
        return new JsonObjectEncrypter(static::asJson($key));
    }

    public static function asJson($key = "")
    {
        return new JsonEncrypter(static::asSerializer($key));
    }

    public static function asSerializer($key = "")
    {
        return new SerializeEncrypter(new LaravelEncrypter($key));
    }
}