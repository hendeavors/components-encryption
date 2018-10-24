<?php

namespace Endeavors\Components\Encryption\Tests;

use Endeavors\Components\Encryption\JsonEncrypter;
use Endeavors\Components\Encryption\JsonObjectEncrypter;
use Endeavors\Components\Encryption\LaravelEncrypter;
use Endeavors\Components\Encryption\Crypt;

class JsonEncryptionTest extends \Orchestra\Testbench\TestCase
{
    private $key = 'fFpIpUZQW2VJCp0h';

    public function setUp()
    {
        parent::setUp();
    }

    public function testCanEncrypt()
    {
        $encrypter = new JsonEncrypter(
            new LaravelEncrypter($this->key)
        );

        $this->assertTrue(is_string($encrypter->encrypt("item")));
        $this->assertTrue(is_string($encrypter->encrypt(["item"])));
    }

    public function testCanDecrypt()
    {
        $encrypter = new JsonEncrypter(
            new LaravelEncrypter($this->key)
        );
        $value = $encrypter->encrypt("item");
        $decrypted = $encrypter->decrypt($value);
        $this->assertEquals($decrypted, "item");

        $encrypter = new JsonEncrypter(
            new LaravelEncrypter($this->key)
        );
        $value = $encrypter->encrypt(["item"]);
        $decrypted = $encrypter->decrypt($value);
        $this->assertEquals($decrypted, ["item"]);

        $encrypter = new JsonEncrypter(
            new LaravelEncrypter($this->key)
        );
        $value = $encrypter->encrypt(["one" => "item"]);
        $decrypted = $encrypter->decrypt($value);
        $this->assertEquals($decrypted, ["one" => "item"]);
        
        $encrypter = new JsonEncrypter(
            new LaravelEncrypter($this->key)
        );
        $encrypter->decryptAsObject();
        $value = $encrypter->encrypt(["one" => "item"]);
        $decrypted = $encrypter->decrypt($value);
        $this->assertEquals($decrypted, (object)["one" => "item"]);

        $encrypter = new JsonEncrypter(
            new LaravelEncrypter($this->key)
        );
        $encrypter = new JsonObjectEncrypter($encrypter);
        $value = $encrypter->encrypt(["one" => "item"]);
        $decrypted = $encrypter->decrypt($value);
        $this->assertEquals($decrypted, (object)["one" => "item"]);
    }

    public function testCanFactoryEncrypt()
    {
        $encrypter = Crypt::asObject($this->key);
        $value = $encrypter->encrypt(["one" => "item"]);
        $decrypted = $encrypter->decrypt($value);
        $this->assertEquals($decrypted, (object)["one" => "item"]);

        $encrypter = Crypt::asObject($this->key);
        $value = $encrypter->encrypt("item");
        $decrypted = $encrypter->decrypt($value);
        $this->assertEquals($decrypted, "item");

        $encrypter = Crypt::asJson($this->key);
        $value = $encrypter->encrypt(["one" => "item"]);
        $decrypted = $encrypter->decrypt($value);
        $this->assertEquals($decrypted, ["one" => "item"]);

        $encrypter = Crypt::asSerializer($this->key);
        $value = $encrypter->encrypt(["one" => "item"]);
        $decrypted = $encrypter->decrypt($value);
        $this->assertEquals($decrypted, ["one" => "item"]);
    }
}