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

function includeIfExists($file)
{
    return file_exists($file) ? include $file : false;
}

if ((!$loader = includeIfExists(__DIR__ . '/../vendor/autoload.php')) && (!$loader = includeIfExists(__DIR__ . '/../../../autoload.php'))) {
    echo 'You must set up the project dependencies, run the following commands:' . PHP_EOL .
        'curl -sS https://getcomposer.org/installer | php' . PHP_EOL .
        'php composer.phar install' . PHP_EOL;
    exit(1);
}

return $loader;
