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

use Visithor\Model\Url;
use Visithor\Visithor;
use Visithor\Client\Interfaces\ClientInterface;

/**
 * Class StreamClient
 */
class StreamClient implements ClientInterface
{
    /**
     * Build client
     * @return $this Self object
     */
    public function buildClient() {
        return $this;
    }

    /**
     * Get the HTTP Code Response given an URL instance
     * @param Url $url Url
     * @link http://php.net/manual/ru/function.get-headers.php#97684
     * @return int Response HTTP Code
     */
    public function getResponseHTTPCode(Url $url)
    {
        $code = 400; // error by default

        // prepare context
        $streamContext = [
            'http' => [
                // set verb
                'method' => $url->getOption('verb'),
            ]
        ];

        // is it ajax call?
        if ($url->getOption('ajax')) {
            $streamContext['http']['header'] = Visithor::$ajaxHeaders;
        }

        // set options
        stream_context_set_default($streamContext);
        $headers = get_headers($url->getPath());

        // return error if no code returned
        if (!array_key_exists(0, $headers)) {
            return $code;
        }

        return substr($headers[0], 9, 3);
    }

    /**
     * Nothing to do here
     * @return $this
     */
    public function destroyClient() {
        return $this;
    }
}
