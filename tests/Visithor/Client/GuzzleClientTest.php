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

namespace Mmoreram\tests\Visithor\Client;

use PHPUnit_Framework_TestCase;

use Visithor\Client\GuzzleClient;
use Visithor\Model\Url;

/**
 * Class GuzzleClientTest
 */
class GuzzleClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test client
     */
    public function testClient()
    {
        $client = new GuzzleClient();
        $client->buildClient($this->httpClientMock());
        $url = new Url(
            'http://google.es',
            [301],
            [
                'headers' =>
                    [
                        'User-Agent' =>
                        'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X)',
                    ],
            ]
        );

        $result = $client->getResponseHTTPCode($url);

        $this->assertEquals(
            301,
            $result
        );
    }

    /**
     * httpClientMock
     *
     * @return \GuzzleHttp\Client
     */
    private function httpClientMock()
    {
        if (class_exists('\GuzzleHttp\Ring\Client\MockHandler')) {
            $handler = new \GuzzleHttp\Ring\Client\MockHandler(
                function (array $request) {
                    $this->assertEquals(
                        $request['headers']['User-Agent'][0],
                        'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X)'
                    );

                    return ['status' => 301];
                }
            );
        } else {
            $handler = new \GuzzleHttp\Handler\MockHandler([
                function (\Psr\Http\Message\RequestInterface $request) {
                    $this->assertEquals(
                        $request->getHeader('user-agent')[0],
                        'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X)'
                    );

                    return new \GuzzleHttp\Psr7\Response(301);
                }
            ]);
        }

        return new \GuzzleHttp\Client(['handler' => $handler]);
    }
}
