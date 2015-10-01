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

class Cookie
{
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

        if ($this->get($key) && $this->get($value) === $value) {
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
}