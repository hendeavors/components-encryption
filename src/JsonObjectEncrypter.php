<?php

namespace Endeavors\Components\Encryption;

use Endeavors\Components\Encryption\Contracts\IEncrypter;
use Endeavors\Components\Encryption\Contracts\IOriginalEncrypter;

class JsonObjectEncrypter implements IEncrypter
{
    private $encrypter;

    public function __construct(IEncrypter $encrypter)
    {
        $this->encrypter = $encrypter->decryptAsObject();
    }

    public function encrypt($value)
    {
        return $this->encrypter->encrypt($value);
    }

    public function decrypt(string $value)
    {
        return $this->encrypter->decrypt($value);
    }
}