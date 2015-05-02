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

namespace Mmoreram\src\Visithor\Renderer;

use Symfony\Component\Console\Output\OutputInterface;

use Visithor\Model\Url;
use Visithor\Renderer\Interfaces\RendererInterface;

/**
 * Class PrettyRenderer
 */
class PrettyRenderer implements RendererInterface
{
    /**
     * Renders an URL execution
     *
     * @param OutputInterface $output Output
     * @param Url     $url      Url
     * @param string  $HTTPCode Returned HTTP Code
     * @param boolean $success  Successfully executed
     *
     * @return $this Self object
     */
    public function render(
        OutputInterface $output,
        Url $url,
        $HTTPCode,
        $success
    )
    {
        $content = $success
            ? 'OK'
            : 'FAIL';

        $output->writeln('[' . $HTTPCode . '] ' . $url->getPath() . ' -- ' . $content);

        return $this;
    }
}
