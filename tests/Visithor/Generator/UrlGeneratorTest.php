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

namespace Mmoreram\tests\Visithor\Generator;

use PHPUnit_Framework_TestCase;

use Visithor\Factory\UrlChainFactory;
use Visithor\Factory\UrlFactory;
use Visithor\Generator\UrlGenerator;
use Visithor\Model\Url;

/**
 * Class UrlGeneratorTest
 */
class UrlGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Generate UrlGenerator
     */
    public function getUrlGeneratorInstance()
    {
        return new UrlGenerator(
            new UrlFactory(),
            new UrlChainFactory()
        );
    }

    /**
     * Test empty config
     */
    public function testEmptyConfig()
    {
        $urls = $this
            ->getUrlGeneratorInstance()
            ->generate([])
            ->getUrls();

        $this->assertEquals(
            [],
            $urls
        );
    }

    /**
     * Test acceptable HTTPCodes
     *
     * @dataProvider dataAcceptableHTTPCodes
     */
    public function testAcceptableHTTPCodes($config, $HTTPCodes)
    {
        $urls = $this
            ->getUrlGeneratorInstance()
            ->generate($config)
            ->getUrls();

        /**
         * @var Url $firstUrl
         */
        $firstUrl = reset($urls);

        $this->assertEquals(
            $HTTPCodes,
            $firstUrl->getAcceptableHttpCodes()
        );
    }

    /**
     * Data for testAcceptableHTTPCodes
     */
    public function dataAcceptableHTTPCodes()
    {
        return [
            [
                [
                    'defaults' => '',
                    'urls'     => [
                        ['/url'],
                    ],
                ],
                [200],
            ],
            [
                [
                    'defaults' => [],
                    'urls'     => [
                        ['/url'],
                    ],
                ],
                [200],
            ],
            [
                [
                    'defaults' => [
                        'http_codes' => [

                        ],
                    ],
                    'urls'     => [
                        ['/url'],
                    ],
                ],
                [200],
            ],
            [
                [
                    'defaults' => [
                        'http_codes' => [
                            304,
                        ],
                    ],
                    'urls'     => [
                        ['/url'],
                    ],
                ],
                [304],
            ],
            [
                [
                    'defaults' => [
                        'http_codes' => 304,
                    ],
                    'urls'     => [
                        ['/url'],
                    ],
                ],
                [304],
            ],
            [
                [
                    'urls' => [
                        ['/url'],
                    ],
                ],
                [200],
            ],
            [
                [
                    'urls' => [
                        ['/url', 200],
                    ],
                ],
                [200],
            ],
            [
                [
                    'urls' => [
                        ['/url', [200]],
                    ],
                ],
                [200],
            ],
            [
                [
                    'urls' => [
                        ['/url', []],
                    ],
                ],
                [200],
            ],
        ];
    }

    /**
     * Test url path
     *
     * @dataProvider dataUrlPath
     */
    public function testUrlPath($config, $path)
    {
        $urls = $this
            ->getUrlGeneratorInstance()
            ->generate($config)
            ->getUrls();

        /**
         * @var Url $firstUrl
         */
        $firstUrl = reset($urls);

        $this->assertEquals(
            $path,
            $firstUrl->getPath()
        );
    }

    /**
     * Data for testUrlPath
     */
    public function dataUrlPath()
    {
        return [
            [
                [
                    'urls' => ['/url'],
                ],
                '/url',
            ],
            [
                [
                    'urls' => [['/url']],
                ],
                '/url',
            ],
        ];
    }

    /**
     * Test url options
     *
     * @dataProvider dataUrlOptions
     */
    public function testUrlOptions($config, $options)
    {
        $urls = $this
            ->getUrlGeneratorInstance()
            ->generate($config)
            ->getUrls();

        /**
         * @var Url $firstUrl
         */
        $firstUrl = reset($urls);

        $this->assertEquals(
            $options,
            $firstUrl->getOptions()
        );
    }

    /**
     * Data for testUrlOptions
     */
    public function dataUrlOptions()
    {
        return [
            [
                [
                    'urls' => [
                        ['/url'],
                    ],
                ],
                [],
            ],
            [
                [
                    'urls' => [
                        ['/url', 200, []],
                    ],
                ],
                [],
            ],
            [
                [
                    'urls' => [
                        ['/url', 200, [
                            'field' => 'value',
                        ]],
                    ],
                ],
                ['field' => 'value'],
            ],
            [
                [
                    'defaults' => [
                        'options' => [
                            'anotherField' => 'anotherValue',
                        ],
                    ],
                    'urls' => [
                        ['/url', 200, [
                            'field' => 'value',
                        ]],
                    ],
                ],
                [
                    'field' => 'value',
                    'anotherField' => 'anotherValue',
                ],
            ],
            [
                [
                    'defaults' => [
                        'options' => [
                            'field' => 'onevalue',
                        ],
                    ],
                    'urls' => [
                        ['/url', 200, [
                            'field' => 'overwrittenvalue',
                        ]],
                    ],
                ],
                [
                    'field' => 'overwrittenvalue',
                ],
            ],
            [
                [
                    'defaults' => [
                        'options' => [
                            'field' => 'onevalue',
                        ],
                    ],
                    'urls' => [
                        ['/url', 200],
                    ],
                ],
                [
                    'field' => 'onevalue',
                ],
            ],
        ];
    }
}
