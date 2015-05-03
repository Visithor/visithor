<?php

/*
 * This file is part of the Visithor package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

namespace Visithor\Client\Interfaces;

use Visithor\Model\Url;

/**
 * Interface ClientInterface
 */
interface ClientInterface
{
    /**
     * Build client
     *
     * @return $this Self object
     */
    public function buildClient();

    /**
     * Get the HTTP Code Response given an URL instance
     *
     * @param Url $url Url
     *
     * @return int Response HTTP Code
     */
    public function getResponseHTTPCode(Url $url);

    /**
     * Destroy client
     *
     * @return $this Self object
     */
    public function destroyClient();
}
