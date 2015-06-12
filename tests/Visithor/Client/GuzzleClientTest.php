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
     * @var \Visithor\Client\GuzzleClient
     */
    protected $client;

    public function setUp()
    {
        $this->client = new GuzzleClient();
        $this->client->buildClient();
    }

    public function tearDown()
    {
        $this->client = null;
    }

    /**
     * @dataProvider generateRequests
     * @param string $url
     * @param int    $code
     */
    public function testClient( $url, $code )
    {
        $url = new Url($url, [$code]);
        $result = $this->client->getResponseHTTPCode($url);
        $this->assertEquals($code, $result);
    }

    /**
     * Generate URL - code pares to test the client
     * @todo add a url for 500
     * @return array
     */
    public function generateRequests()
    {
        return array(
            array( 'http://google.es', 200 ),
            array( 'http://example.com/404', 404 ),
        );
    }
}
