<?php

namespace Endeavors\Components\Encryption;

use Endeavors\Components\Encryption\Contracts\IEncrypter;
use Endeavors\Components\Encryption\Contracts\IOriginalEncrypter;

class SerializeEncrypter implements IOriginalEncrypter
{
    private $encrypter;

    public function __construct(IOriginalEncrypter $encrypter)
    {
        $this->encrypter = $encrypter;
    }

    public function encrypt($value, $serialize = true)
    {
        return $this->encrypter->encrypt($value, $serialize);
    }

    public function decrypt($value, $serialize = true)
    {
        return $this->encrypter->decrypt($value, $serialize);
    }
}