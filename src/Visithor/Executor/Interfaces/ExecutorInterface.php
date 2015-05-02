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

namespace Visithor\Executor\Interfaces;

use Symfony\Component\Console\Output\OutputInterface;

use Visithor\Client\Interfaces\ClientInterface;
use Visithor\Model\UrlChain;
use Visithor\Renderer\Interfaces\RendererInterface;

/**
 * Interface ExecutorInterface
 */
interface ExecutorInterface
{
    /**
     * Given a Client, an UrlChain instance and a renderer, executes all urls
     * and renders the result.
     *
     * If all urls are executed as expected, then the result of the operation
     * will be 0. Otherwise, the result will be 1.
     *
     * @param ClientInterface   $client   Client
     * @param UrlChain          $urlChain Url chain
     * @param RendererInterface $renderer Renderer
     * @param OutputInterface $output Output
     *
     * @return int Result of the execution
     */
    public function execute(
        ClientInterface   $client,
        UrlChain $urlChain,
        RendererInterface $renderer,
        OutputInterface $output
    );
}
