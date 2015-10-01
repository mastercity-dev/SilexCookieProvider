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

class Cryptor
{
    protected $salt;

    /**
     * @param $salt
     */
    public function __construct($salt)
    {
        if (!$salt || gettype($salt) !== 'string') {
            throw new \LogicException(sprintf("Invalid salt."));
        }

        $this->salt = $salt;
    }

    /**
     * @param $string
     * @return string
     */
    public function encrypt($string)
    {
        $encrypted = openssl_encrypt($string, 'aes128', $this->salt);

        return rtrim($encrypted, '==');
    }

    /**
     * @param $encrypted
     * @return string
     */
    public function decrypt($encrypted)
    {
        $encrypted = $encrypted . '==';
        $decrypted = openssl_decrypt($encrypted, 'aes128', $this->salt);

        return $decrypted;
    }
}