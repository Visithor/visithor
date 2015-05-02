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

namespace Visithor\Generator\Interfaces;

use Visithor\Model\UrlChain;

/**
 * Interface UrlGeneratorInterface
 */
interface UrlGeneratorInterface
{
    /**
     * Given a configuration array, generates a chain of urls
     *
     * @param array $config Configuration
     *
     * @return UrlChain Chain of URL instances
     */
    public function generate(array $config);
}
