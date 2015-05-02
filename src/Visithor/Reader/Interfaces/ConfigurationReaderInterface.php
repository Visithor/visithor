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

namespace Visithor\Reader\Interfaces;

/**
 * Interface ConfigurationReaderInterface
 */
interface ConfigurationReaderInterface
{
    /**
     * Read all the configuration given a source
     *
     * @param string $path Path
     *
     * @return array Configuration
     */
    public function read($path);
}
