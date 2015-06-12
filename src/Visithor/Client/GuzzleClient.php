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
     * A list of CURL protocols to define for hhvm
     * @link http://php.net/manual/ru/function.curl-setopt.php
     * @var array
     */
    protected $curlProtocols = [
        "CURLPROTO_HTTP" => 1,
        "CURLPROTO_HTTPS" => 2,
        "CURLPROTO_FTP" => 4,
        "CURLPROTO_FTPS" => 8,
        "CURLPROTO_SCP" => 16,
        "CURLPROTO_SFTP" => 32,
        "CURLPROTO_TELNET" => 64,
        "CURLPROTO_LDAP" => 128,
        "CURLPROTO_LDAPS" => 256,
        "CURLPROTO_DICT" => 512,
        "CURLPROTO_FILE" => 1024,
        "CURLPROTO_TFTP" => 2048,
        "CURLPROTO_ALL" => -1
    ];

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

        // add constant for hhvm
        array_walk($this->curlProtocols, function( $item, $key ) {
            if (!defined($key)) {
                define($key, $item);
            }
        });
    }

    /**
     * @return array
     */
    protected function generateAjaxHeaders()
    {
        return [
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'X_REQUESTED_WITH' => 'XMLHttpRequest',
                'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
            ],
        ];
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
        // presume we don't know what happened
        $result = 000;

        try {
            $verb = $url->getOption('verb', 'GET');

            // add header if ajax
            $options = ($url->getOption('ajax', false))
                ? $this->generateAjaxHeaders()
                : [];

            $client = $this->client;
            $result = $client
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
