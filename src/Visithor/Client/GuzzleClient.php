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
     * Build client
     *
     * @return $this Self object
     */
    public function buildClient($client = null)
    {
        //Handle redirect configuration for guzzle 6
        if (class_exists('\GuzzleHttp\Psr7\Request')) {
            $options = ['allow_redirects' => false];
        } else {
            $options = [
                'defaults' => [
                    'allow_redirects' => false
                ]
            ];
        }

        $this->client = $client ?: new Client(
            $options
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
            $verb = $url->getOption('verb', 'GET');
            $headers = $url->getOption('headers', []);
            $client = $this->client;
            $result = $client
                 ->send(
                     class_exists('\GuzzleHttp\Psr7\Request')
                        ? new \GuzzleHttp\Psr7\Request($verb, $url->getPath(), $headers)
                        : $client->createRequest($verb, $url->getPath(), ['headers' => $headers])
                 )
                 ->getStatusCode();
        } catch (Exception $e) {
            $result = 400;
        }

        return $result;
    }

    /**
     * Destroy client
     *
     * @return $this Self object
     */
    public function destroyClient()
    {
        unset($this->client);
    }
}
