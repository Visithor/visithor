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
    public function __construct(
        UrlFactory $urlFactory,
        UrlChainFactory $urlChainFactory
    ) {
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
        $defaultOptions = $this->getDefaultOptions($config);

        return $this->createUrlChainFromConfig(
            $config,
            $defaultHTTPCodes,
            $defaultOptions
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
     * Get default options
     *
     * @param array $config Configuration
     *
     * @return array Default options
     */
    protected function getDefaultOptions($config)
    {
        $defaultOptions = (
            isset($config['defaults']) &&
            is_array($config['defaults']) &&
            isset($config['defaults']['options']) &&
            is_array($config['defaults']['options'])
        )
            ? $config['defaults']['options']
            : [];

        return $defaultOptions;
    }

    /**
     * Given a config array, create an URLChain instance filled with all defined
     * URL instances.
     *
     * @param array    $config           Configuration
     * @param string[] $defaultHTTPCodes Array of HTTP Codes
     * @param array    $defaultOptions   Default options
     *
     * @return Url[] Array of URL instances
     */
    protected function createUrlChainFromConfig(
        array $config,
        array $defaultHTTPCodes,
        array $defaultOptions
    ) {
        $urlChain = $this
            ->urlChainFactory
            ->create();

        if (
            !isset($config['urls']) ||
            !is_array($config['urls'])
        ) {
            return $urlChain;
        }

        $profiles = (
            isset($config['profiles']) &&
            is_array($config['profiles'])
        )
            ? $config['profiles']
            : [];

        foreach ($config['urls'] as $urlConfig) {
            $urlChain->addUrl(
                $this->getURLInstanceFromConfig(
                    $urlConfig,
                    $defaultHTTPCodes,
                    $defaultOptions,
                    $profiles
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
     * @param array    $defaultOptions   Default options
     * @param array    $profiles         Profiles
     *
     * @return URL Url instance
     */
    protected function getUrlInstanceFromConfig(
        $urlConfig,
        array $defaultHTTPCodes,
        array $defaultOptions,
        array $profiles
    ) {
        $url = $this->getUrlPathFromConfig($urlConfig);

        $urlHTTPCodes = $this->getUrlHTTPCodesFromConfig(
            $urlConfig,
            $defaultHTTPCodes
        );

        $urlOptions = $this->getUrlOptionsFromConfig(
            $urlConfig,
            $defaultOptions
        );

        if (
            isset($urlOptions['profile']) &&
            isset($profiles[$urlOptions['profile']]) &&
            is_array($profiles[$urlOptions['profile']])
        ) {
            $urlOptions = array_merge(
                $profiles[$urlOptions['profile']],
                $urlOptions
            );
        }

        return $this
            ->urlFactory
            ->create(
                $url,
                $urlHTTPCodes,
                $urlOptions
            );
    }

    /**
     * Build the url given the configuration data
     *
     * @param mixed $urlConfig Url configuration
     *
     * @return string Route path
     */
    protected function getUrlPathFromConfig($urlConfig)
    {
        return is_array($urlConfig)
            ? $urlConfig[0]
            : $urlConfig;
    }

    /**
     * Get url HTTP Codes given its configuration
     *
     * @param mixed    $urlConfig        Url configuration
     * @param string[] $defaultHTTPCodes Array of HTTP Codes
     *
     * @return string[] Set of HTTP Codes
     */
    protected function getUrlHTTPCodesFromConfig(
        $urlConfig,
        array $defaultHTTPCodes
    ) {
        $HTTPCodes = (
            is_array($urlConfig) &&
            isset($urlConfig[1]) &&
            !empty($urlConfig[1])
        )
            ? $urlConfig[1]
            : $defaultHTTPCodes;

        return is_array($HTTPCodes)
            ? $HTTPCodes
            : [$HTTPCodes];
    }

    /**
     * Get url options
     *
     * @param mixed $urlConfig      Url configuration
     * @param array $defaultOptions Default options
     *
     * @return string[] Set of HTTP Codes
     */
    protected function getUrlOptionsFromConfig(
        $urlConfig,
        array $defaultOptions
    ) {
        $urlOptions = (
            is_array($urlConfig) &&
            isset($urlConfig[2]) &&
            is_array($urlConfig[2])
        )
            ? $urlConfig[2]
            : [];

        return array_merge(
            $defaultOptions,
            $urlOptions
        );
    }
}
