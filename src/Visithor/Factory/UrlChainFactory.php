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

namespace Visithor\Factory;

use Visithor\Model\UrlChain;

/**
 * Class UrlChainFactory
 */
class UrlChainFactory
{
    /**
     * Create an Url instance
     *
     * @return UrlChain New url chain instance
     */
    public function create()
    {
        return new UrlChain();
    }
}
