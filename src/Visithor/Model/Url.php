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

namespace Visithor\Model;


/**
 * Class Url
 */
class Url
{
    /**
     * @var string
     *
     * Url path
     */
    protected $path;

    /**
     * @var string[]
     *
     * Set of Acceptable HTTP Codes
     */
    protected $acceptableHTTPCodes;

    /**
     * @var array
     *
     * Options
     */
    protected $options;

    /**
     * Construct
     *
     * @param string   $path                Path
     * @param string[] $acceptableHTTPCodes Acceptable Http codes
     * @param array    $options             Options
     */
    public function __construct(
        $path,
        array $acceptableHTTPCodes,
        array $options
    ) {
        $this->path = $path;
        $this->acceptableHTTPCodes = $acceptableHTTPCodes;
        $this->options = $options;
    }

    /**
     * Get Path
     *
     * @return string Path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get Acceptable HttpCodes
     *
     * @return string[] HttpCodes
     */
    public function getAcceptableHttpCodes()
    {
        return $this->acceptableHTTPCodes;
    }

    /**
     * Get Options
     *
     * @return array Options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get Options
     *
     * @param string $option  Option name
     * @param mixed  $default Default value
     *
     * @return mixed Option value
     */
    public function getOption($option, $default = null)
    {
        return array_key_exists($option, $this->options)
            ? $this->options[$option]
            : $default;
    }
}
