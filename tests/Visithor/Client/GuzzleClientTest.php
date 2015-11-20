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
        $client->buildClient();
        $url = new Url(
            'http://google.es',
            [301],
            []
        );

        $result = $client->getResponseHTTPCode($url);

        $this->assertEquals(
            301,
            $result
        );
    }
}
