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

namespace Visithor;

/**
 * Class Visithor
 */
class Visithor
{
    /**
     * @var string
     *
     * Configuration file
     */
    const CONFIG_FILE_NAME = 'visithor.yml';

    /**
     * @var string
     *
     * Configuration file
     */
    const CONFIG_FILE_NAME_DISTR = 'visithor.yml.dist';

    /**
     * @var string
     *
     * Renderer type dot
     */
    const RENDERER_TYPE_DOT = 'dots';

    /**
     * @var string
     *
     * Renderer type pretty
     */
    const RENDERER_TYPE_PRETTY = 'pretty';

    /**
     * Headers sent to check for ajax call
     * @var array
     */
    public static $ajaxHeaders = [
        'X-Requested-With' => 'XMLHttpRequest',
        'X_REQUESTED_WITH' => 'XMLHttpRequest',
        'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
    ];
}
