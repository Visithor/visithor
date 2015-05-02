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

namespace Visithor\Executor;

use Symfony\Component\Console\Output\OutputInterface;

use Visithor\Client\Interfaces\ClientInterface;
use Visithor\Executor\Interfaces\ExecutorInterface;
use Visithor\Model\Url;
use Visithor\Model\UrlChain;
use Visithor\Renderer\Interfaces\RendererInterface;

/**
 * Class Executor
 */
class Executor implements ExecutorInterface
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
     * @param OutputInterface   $output   Output
     *
     * @return int Result of the execution
     */
    public function execute(
        ClientInterface $client,
        UrlChain $urlChain,
        RendererInterface $renderer,
        OutputInterface $output
    )
    {
        $result = 0;

        foreach ($urlChain->getUrls() as $url) {

            $result = $result | $this->executeUrl(
                    $client,
                    $url,
                    $renderer,
                    $output
                );
        }

        return $result;
    }

    /**
     * Executes an URL and render the result given a renderer.
     *
     * If the url is executed as expected, then the result of the operation will
     * be 0. Otherwise, the result will be 1.
     *
     * @param ClientInterface   $client   Client
     * @param Url               $url      Url
     * @param RendererInterface $renderer Renderer
     * @param OutputInterface   $output   Output
     *
     * @return boolean Result of the execution
     */
    public function executeUrl(
        ClientInterface $client,
        Url $url,
        RendererInterface $renderer,
        OutputInterface $output
    )
    {
        $resultHTTPCode = $client->getResponseHTTPCode($url);
        $resultExecution = in_array(
            $resultHTTPCode,
            $url->getAcceptableHttpCodes()
        );

        $renderer->render(
            $output,
            $url,
            $resultHTTPCode,
            $resultExecution
        );

        return $resultExecution;
    }
}
