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

namespace Mmoreram\tests\Visithor\Executor;

use PHPUnit_Framework_TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

use Visithor\Client\Interfaces\ClientInterface;
use Visithor\Executor\Executor;
use Visithor\Model\Url;
use Visithor\Model\UrlChain;

/**
 * Class ExecutorTest
 */
class ExecutorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test final result given first partial results
     *
     * @dataProvider dataExecute
     */
    public function testExecute($firstStatusCode, $expectedResult)
    {
        /**
         * @var ClientInterface|ObjectProphecy $client
         */
        $client = $this->prophesize('Visithor\Client\Interfaces\ClientInterface');
        $client
            ->getResponseHTTPCode(Argument::any())
            ->willReturn(200);

        $client
            ->buildClient(Argument::any())
            ->willReturn(Argument::any());

        $client
            ->destroyClient(Argument::any())
            ->willReturn(Argument::any());

        $urlChain = new UrlChain();
        $urlChain
            ->addUrl(new Url('', $firstStatusCode))
            ->addUrl(new Url('', [200]))
            ->addUrl(new Url('', [200]));

        $executor = new Executor(
            $client->reveal()
        );

        $result = $executor
            ->execute(
                $urlChain,
                $this->prophesize('Visithor\Renderer\Interfaces\RendererInterface')->reveal(),
                $this->prophesize('Symfony\Component\Console\Output\OutputInterface')->reveal()
            );

        $this->assertEquals(
            $expectedResult,
            $result
        );
    }

    /**
     * Data for testExecute
     */
    public function dataExecute()
    {
        return [
            [[200], 0],
            [[301, 200], 0],
            [[301], 1],
        ];
    }
}
