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

namespace Visithor\Generator;

use Visithor\Factory\UrlChainFactory;
use Visithor\Factory\UrlFactory;
use Visithor\Model\Url;
use Visithor\Model\UrlChain;

/**
 * Class UrlGenerator
 */
class UrlGenerator
{
    /**
     * @var UrlFactory
     *
     * Url factory
     */
    protected $urlFactory;

    /**
     * @var UrlChainFactory
     *
     * UrlChain factory
     */
    protected $urlChainFactory;

    /**
     * Construct
     *
     * @param UrlFactory      $urlFactory      Url factory
     * @param UrlChainFactory $urlChainFactory UrlChain factory
     */
    function __construct(
        UrlFactory $urlFactory,
        UrlChainFactory $urlChainFactory
    )
    {
        $this->urlFactory = $urlFactory;
        $this->urlChainFactory = $urlChainFactory;
    }

    /**
     * Given a configuration array, generates a chain of urls
     *
     * @param array $config Configuration
     *
     * @return UrlChain Chain of URL instances
     */
    public function generate(array $config)
    {
        $defaultHTTPCodes = $this->getDefaultHTTPCodes($config);

        return $this->createUrlChainFromConfig(
            $config,
            $defaultHTTPCodes
        );
    }

    /**
     * Get default http Codes
     *
     * @param array $config Configuration
     *
     * @return string[] Array of HTTP Codes
     */
    protected function getDefaultHTTPCodes($config)
    {
        $defaultHttpCodes = (
            isset($config['defaults']) &&
            is_array($config['defaults']) &&
            isset($config['defaults']['http_codes']) &&
            !empty($config['defaults']['http_codes'])
        )
            ? $config['defaults']['http_codes']
            : [200];

        if (!is_array($defaultHttpCodes)) {

            $defaultHttpCodes = [$defaultHttpCodes];
        }

        return $defaultHttpCodes;
    }

    /**
     * Given a config array, create an URLChain instance filled with all defined
     * URL instances.
     *
     * @param array    $config           Configuration
     * @param string[] $defaultHTTPCodes Array of HTTP Codes
     *
     * @return Url[] Array of URL instances
     */
    protected function createUrlChainFromConfig(
        array $config,
        array $defaultHTTPCodes
    )
    {
        $urlChain = $this
            ->urlChainFactory
            ->create();

        if (
            !isset($config['urls']) ||
            !is_array($config['urls'])
        ) {

            return $urlChain;
        }

        foreach ($config['urls'] as $urlConfig) {

            $urlChain->addUrl(
                $this->getURLInstanceFromConfig(
                    $urlConfig,
                    $defaultHTTPCodes
                )
            );
        }

        return $urlChain;
    }

    /**
     * Get Url instance given its configuration
     *
     * @param mixed    $urlConfig        Url configuration
     * @param string[] $defaultHTTPCodes Array of HTTP Codes
     *
     * @return URL Url instance
     */
    protected function getURLInstanceFromConfig(
        $urlConfig,
        array $defaultHTTPCodes
    )
    {
        $url = is_array($urlConfig)
            ? $urlConfig[0]
            : $urlConfig;

        $urlHTTPCodes = $this->getURLHTTPCodesFromConfig(
            $urlConfig,
            $defaultHTTPCodes
        );

        return $this
            ->urlFactory
            ->create(
                $url,
                $urlHTTPCodes
            );
    }

    /**
     * Get url HTTP Codes given its configuration
     *
     * @param mixed    $urlConfig        Url configuration
     * @param string[] $defaultHTTPCodes Array of HTTP Codes
     *
     * @return string[] Set of HTTP Codes
     */
    protected function getURLHTTPCodesFromConfig(
        $urlConfig,
        array $defaultHTTPCodes
    )
    {
        $HTTPCodes = (
            is_array($urlConfig) &&
            isset($urlConfig[1])
        )
            ? $urlConfig[1]
            : $defaultHTTPCodes;

        return is_array($HTTPCodes)
            ? $HTTPCodes
            : [$HTTPCodes];
    }
}
