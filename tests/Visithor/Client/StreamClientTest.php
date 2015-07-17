<?php

/**
 * This file is part of the Visithor package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Igor Timoshenkov <igor.timoshenkov@gmail.com>
 */

namespace Mmoreram\tests\Visithor\Client;

use PHPUnit_Framework_TestCase;
use Visithor\Client\StreamClient;
use Visithor\Model\Url;

/**
 * Class GuzzleClientTest
 */
class StreamClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Visithor\Client\Interfaces\ClientInterface
     */
    protected $client;

    /**
     * Prepare
     */
    public function setUp() {
        $this->client = new StreamClient();
        $this->client->buildClient();
    }

    /**
     * Clean-up
     */
    public function tearDown() {
        $this->client = null;
        unset($this->client);
    }

    /**
     * @dataProvider generateRequests
     * @param string $url
     * @param int    $code
     */
    public function testClient($url, $code)
    {
        $url = new Url($url, [$code]);
        $result = $this->client->getResponseHTTPCode($url);
        $this->assertEquals($code, $result);
    }

    /**
     * Generate URL - code pares to test the client
     * @return array
     */
    public function generateRequests()
    {
        return [
            [ 'http://google.es', 301 ],
            [ 'http://example.com/404', 404 ],
        ];
    }
}
