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
 * Class UrlChain
 */
class UrlChain
{
    /**
     * @var array
     *
     * Urls
     */
    protected $urls;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->urls = [];
    }

    /**
     * Add url
     *
     * @param Url $url Url
     *
     * @return $this Self object
     */
    public function addUrl(Url $url)
    {
        $this->urls[] = $url;

        return $this;
    }

    /**
     * Get urls
     *
     * @return Url[] Urls loaded
     */
    public function getUrls()
    {
        return $this->urls;
    }
}
