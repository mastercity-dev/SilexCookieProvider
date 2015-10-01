<?php

/*
 * This file is part of the Redneck1\SilexCookieProvider.
 *
 * (c) Pavel Mukhin <mukhin@mastercity.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redneck1\SilexCookieProvider;

use Crypto;

class Cookie
{
    private $salt = null;

    public function __construct($salt = null)
    {
        if (null !== $salt) {
            $this->salt = $salt;
        }
    }

    /**
     * @param string $key
     * @return string
     */
    public function get($key, $default = null)
    {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }

        if (null !== $default && is_string($default)) {
            return $default;
        }

        return '';
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $_COOKIE;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return isset($_COOKIE[$key]) ? true : false;
    }

    /**
     * @param $name
     * @param $value
     * @param int $expires
     * @param string $path
     * @param bool|false $domain
     * @return bool|false
     */
    public function set($key, $value, $expires = 86400, $path = '/', $domain = false)
    {
        if (!isset($_SERVER['HTTP_HOST'])) {
            throw new \LogicException("Can't set cookie because no browser is behind this request.");
        }

        if (!$domain) {
            $domain = $_SERVER['HTTP_HOST'];
        }

        $expires = time() + $expires;

        setcookie($key, $value, $expires, $path, $domain);

        if ($this->get($key) === $value) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key
     * @return bool|false;
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            return $this->set($key, '', (time() - 3000));
        }

        return false;
    }

    public function setEncrypted($key, $value, $expires = 86400, $path = '/', $domain = false)
    {
        if (null === $this->salt) {
            throw new \LogicException("Can't set encrypted cookie as no salt was specified.");
        }

        $cryptor = new Cryptor($this->salt);

        $encryptedKey = $cryptor->encrypt($key);
        $encryptedValue = $cryptor->encrypt($value);

        return $this->set($encryptedKey, $encryptedValue, $expires = 86400, $path = '/', $domain = false);
    }

    public function getAllDecrypted()
    {
        if (null === $this->salt) {
            throw new \LogicException("Can't decrypt cookie as no salt was specified.");
        }

        $cryptor = new Cryptor($this->salt);
        $decrypted = [];

        foreach ($_COOKIE as $key => $value) {
            $decryptedKey = $cryptor->decrypt($key);
            $decryptedValue = $cryptor->decrypt($value);

            $decrypted[$decryptedKey] = $decryptedValue;
        }

        return $decrypted;
    }

    public function hasEncrypted($key)
    {
        if (null === $this->salt) {
            throw new \LogicException("Can't encrypt cookie key as no salt was specified.");
        }

        $cryptor = new Cryptor($this->salt);
        $cryptedKey = $cryptor->encrypt($key);

        return isset($_COOKIE[$cryptedKey]) ? true : false;
    }

    public function getEncrypted($key)
    {
        if (null === $this->salt) {
            throw new \LogicException("Can't decrypt cookie as no salt was specified.");
        }

        $cryptor = new Cryptor($this->salt);
        $cryptedKey = $cryptor->encrypt($key);

        if (!isset($_COOKIE[$cryptedKey])) {
            return '';
        }

        $cryptedValue = $_COOKIE[$cryptedKey];

        return $cryptor->decrypt($cryptedValue);
    }
}