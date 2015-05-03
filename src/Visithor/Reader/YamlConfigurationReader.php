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

namespace Visithor\Reader;

use Symfony\Component\Yaml\Parser as YamlParser;

use Visithor\Visithor;

/**
 * Class YamlConfigurationReader
 */
class YamlConfigurationReader
{
    /**
     * Read all the configuration given a path
     *
     * @param string $path Path
     *
     * @return array|false Configuration loaded or false if file not exists
     */
    public function read($path)
    {
        $config = $this
            ->readByFilename(
                $path,
                Visithor::CONFIG_FILE_NAME_DISTR
            );

        if (false === $config) {
            $config = $this
                ->readByFilename(
                    $path,
                    Visithor::CONFIG_FILE_NAME
                );
        }

        return $config;
    }

    /**
     * Read all the configuration given a path and a filename
     *
     * @param string $path     Path
     * @param string $filename File name
     *
     *
     * @return array Configuration
     */
    public function readByFilename($path, $filename)
    {
        $config = false;
        $configFilePath = rtrim($path, '/') . '/' . $filename;

        if (is_file($configFilePath)) {
            $yamlParser = new YamlParser();
            $config = $yamlParser->parse(file_get_contents($configFilePath));
        }

        return $config;
    }
}
