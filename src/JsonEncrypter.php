<?php

namespace Endeavors\Components\Encryption;

use Endeavors\Components\Encryption\Contracts\IEncrypter;
use Endeavors\Components\Encryption\Contracts\IOriginalEncrypter;

class JsonEncrypter implements IEncrypter
{
    private $encrypter;

    private $decryptAsObject;

    public function __construct(IOriginalEncrypter $encrypter, $decryptAsObject = false)
    {
        $this->encrypter = $encrypter;

        $this->decryptAsObject = $decryptAsObject;
    }

    public function encrypt($value)
    {
        return $this->encrypter->encrypt($this->asJson($value), false);
    }

    public function decrypt(string $value)
    {
        return $this->fromJson($this->encrypter->decrypt($value, false));
    }

    public function decryptAsObject()
    {
        $this->decryptAsObject = true;

        return new static($this->encrypter, $this->decryptAsObject);
    }

    protected function asJson($value)
    {
        if (!is_string($value)) {
            return json_encode($value);
        }

        return $value;
    }

    protected function fromJson($value)
    {
        if (null === json_decode($value)) {
            return $value;
        }

        if ($this->decryptAsObject) {
            return json_decode($value);
        }

        return json_decode($value, true);
    }
}