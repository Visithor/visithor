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

use Visithor\Renderer\Interfaces\RendererInterface;
use Visithor\Visithor;

/**
 * Class RendererFactory
 */
class RendererFactory
{
    /**
     * Create a new Renderer instance
     *
     * @param string $type Renderer type
     *
     * @return RendererInterface Renderer instance
     */
    public function create($type)
    {
        if ($type === Visithor::RENDERER_TYPE_DOT) {

            return new DotRenderer();
        }

        return new PrettyRenderer();
    }
}
