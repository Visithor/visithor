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
use GuzzleHttp\Exception\RequestException;

use Visithor\Visithor;
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
     * @link http://php.net/manual/de/function.curl-setopt.php
     * @link https://github.com/facebook/hhvm/issues/3737
     * @return $this Self object
     */
    public function buildClient()
    {
        $this->client = new Client(
            ['redirect.disable' => true]
        );
    }

    /**
     * @return array
     */
    protected function generateAjaxHeaders()
    {
        return [
            'future' => true,
            'headers' => Visithor::$ajaxHeaders
        ];
    }

    /**
     * Get the HTTP Code Response given an URL instance
     * @param Url $url Url
     * @link http://ringphp.readthedocs.org/en/latest/client_handlers.html#built-in-handlers
     * @return int Response HTTP Code
     */
    public function getResponseHTTPCode(Url $url)
    {
        // presume we don't know what happened
        $result = 000;

        try {
            $verb = $url->getOption('verb', 'GET');

            // prepare context
            $streamContext = [
                'http' => [
                    // set verb
                    'method' => $verb
                ]
            ];

            // is it ajax call?
            if ($url->getOption('ajax')) {
                $streamContext['http']['header'] = Visithor::$ajaxHeaders;
            }

            // force using streams
            $options['config'] = [
                'stream_context' => $streamContext
            ];

            $result = $this->client
                ->$verb($url->getPath(), $options)
                ->getStatusCode();
        }
        // Guzzle considers that as an error,
        // but we might be expecting a 404 or 500
        catch (RequestException $e) {
            $result = $e->getResponse()->getStatusCode();
        }
        // anything other
        catch (Exception $e) {
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
