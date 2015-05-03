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

use Exception;
use GuzzleHttp\Client;

use Visithor\Client\Interfaces\ClientInterface;
use Visithor\Model\Url;

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
        $this->client = new Client(
            ['redirect.disable' => true]
        );
    }

    /**
     * Get the HTTP Code Response given an URL instance
     *
     * @param Url $url Url
     *
     * @return int Response HTTP Code
     */
    public function getResponseHTTPCode(Url $url)
    {
        try {
            $result = $this
                ->client
                ->get($url->getPath())
                ->getStatusCode();
        } catch (Exception $e) {
            $result = 1;
        }

        return $result;
    }
}
