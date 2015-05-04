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

namespace Visithor\Renderer;

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
     * @param OutputInterface $output   Output
     * @param Url             $url      Url
     * @param string          $HTTPCode Returned HTTP Code
     * @param boolean         $success  Successfully executed
     *
     * @return $this Self object
     */
    public function render(
        OutputInterface $output,
        Url $url,
        $HTTPCode,
        $success
    ) {
        $color = $success
            ? '<bg=green>  </bg=green>'
            : '<bg=red>  </bg=red>';

        $HTTPCode = (200 == $HTTPCode)
            ? '<fg=green>200</fg=green>'
            : $HTTPCode;

        $options = '<fg=cyan>' . json_encode($url->getOptions()) . '</fg=cyan>';

        $output->writeln($color . ' [' . $HTTPCode . '] ' . $url->getPath() . ' ' . $options);

        return $this;
    }
}
