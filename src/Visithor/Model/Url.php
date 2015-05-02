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

namespace Visithor\Model;

/**
 * Class Url
 */
class Url
{
    /**
     * @var string
     *
     * Url path
     */
    protected $path;

    /**
     * @var string[]
     *
     * Set of HTTP Codes
     */
    protected $httpCodes;

    /**
     * Construct
     *
     * @param string   $path      Path
     * @param string[] $httpCodes Http codes
     */
    public function __construct($path, array $httpCodes)
    {
        $this->path = $path;
        $this->httpCodes = $httpCodes;
    }

    /**
     * Get Path
     *
     * @return string Path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get HttpCodes
     *
     * @return string[] HttpCodes
     */
    public function getAcceptableHttpCodes()
    {
        return $this->httpCodes;
    }
}
