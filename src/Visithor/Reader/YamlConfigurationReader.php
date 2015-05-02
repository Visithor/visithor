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

use Visithor\Reader\Interfaces\ConfigurationReaderInterface;
use Visithor\Visithor;

/**
 * Class YamlConfigurationReader
 */
class YamlConfigurationReader implements ConfigurationReaderInterface
{
    /**
     * Read all the configuration given a source
     *
     * @param string $path Path
     *
     * @return array Configuration
     */
    public function read($path)
    {
        $configFilePath = rtrim($path, '/') . '/' . Visithor::CONFIG_FILE_NAME;
        $config = array();

        if (is_file($configFilePath)) {
            $yamlParser = new YamlParser();
            $config = $yamlParser->parse(file_get_contents($configFilePath));
        }

        return $config;
    }


}
