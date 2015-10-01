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

use Silex\Application;
use Silex\ServiceProviderInterface;

class SilexCookieProvider implements ServiceProviderInterface
{
    private $salt;

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        if (isset($options['salt'])) {
            if (gettype($options['salt']) !== 'string') {
                throw new \InvalidArgumentException(sprintf("Salt must be a string, %s given", gettype($options['salt'])));
            }

            $this->salt = $options['salt'];
        }
    }
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['cookie'] = $app->share(function() {
            return new Cookie($this->salt);
        });
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }
}