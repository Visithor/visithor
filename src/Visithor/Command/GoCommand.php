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

namespace Mmoreram\src\Visithor\Command;

use Exception;
use Mmoreram\src\Visithor\Renderer\RendererFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Visithor\Client\GuzzleClient;
use Visithor\Executor\Executor;
use Visithor\Factory\UrlChainFactory;
use Visithor\Factory\UrlFactory;
use Visithor\Generator\UrlGenerator;
use Visithor\Reader\YamlConfigurationReader;
use Visithor\Visithor;

/**
 * Class GoCommand
 */
class GoCommand extends Command
{
    /**
     * configure
     */
    protected function configure()
    {
        $this
            ->setName('visithor:go')
            ->setDescription('Visit all defined urls')
            ->addOption(
                'config',
                'c',
                InputOption::VALUE_OPTIONAL,
                "Config file directory",
                getcwd()
            )
            ->addOption(
                'format',
                'f',
                InputOption::VALUE_OPTIONAL,
                "Format",
                Visithor::RENDERER_TYPE_PRETTY
            );
    }

    /**
     * Execute command
     *
     * @param InputInterface  $input  Input
     * @param OutputInterface $output Output
     *
     * @return int|null|void
     *
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configPath = rtrim($input->getOption('config'), '/');
        $format = $input->getOption('format');

        $reader = new YamlConfigurationReader();
        $config = $reader->read($configPath);

        $urlGenerator = new UrlGenerator(
            new UrlFactory(),
            new UrlChainFactory()
        );
        $urlChain = $urlGenerator->generate($config);

        $client = new GuzzleClient();
        $executor = new Executor();
        $rendererFactory = new RendererFactory();
        $renderer = $rendererFactory->create($format);

        $executor->execute(
            $client,
            $urlChain,
            $renderer,
            $output
        );
    }
}
