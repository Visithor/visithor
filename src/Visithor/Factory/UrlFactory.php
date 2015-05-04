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

use Visithor\Model\Url;

/**
 * Class UrlFactory
 */
class UrlFactory
{
    /**
     * Create an Url instance
     *
     * @param string   $path                Path
     * @param string[] $acceptableHTTPCodes Acceptable Http codes
     * @param array    $options             Options
     *
     * @return Url New url instance
     */
    public function create(
        $path,
        array $acceptableHTTPCodes,
        array $options
    ) {
        return new Url(
            $path,
            $acceptableHTTPCodes,
            $options
        );
    }
}
