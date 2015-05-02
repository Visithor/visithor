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

namespace Visithor\Client;

use GuzzleHttp\Client;

use Visithor\Client\Interfaces\ClientInterface;

/**
 * Class GuzzleClient
 */
class GuzzleClient implements ClientInterface
{
    /**
     * @var Client
     *
     * Guzzle Client
     */
    protected $client;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Get the HTTP Code Response given an url
     *
     * @param string $url Url
     *
     * @return int Response HTTP Code
     */
    public function getResponseHTTPCode($url)
    {
        return $this
            ->client
            ->get($url)
            ->getStatusCode();
    }
}
