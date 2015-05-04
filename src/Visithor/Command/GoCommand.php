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

namespace Visithor\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;

use Visithor\Client\GuzzleClient;
use Visithor\Executor\Executor;
use Visithor\Factory\UrlChainFactory;
use Visithor\Factory\UrlFactory;
use Visithor\Generator\UrlGenerator;
use Visithor\Reader\YamlConfigurationReader;
use Visithor\Renderer\RendererFactory;
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
     * This method returns 0 if all executions passed. 1 otherwise.
     *
     * @param InputInterface  $input  Input
     * @param OutputInterface $output Output
     *
     * @return integer Execution return
     *
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configPath = rtrim($input->getOption('config'), '/');
        $format = $input->getOption('format');

        $reader = new YamlConfigurationReader();
        $config = $reader->read($configPath);

        if (!$config || !is_array($config)) {
            $output->writeln('Configuration file not found in ' . $configPath);

            return 1;
        }

        $output->writeln('Visithor by Marc Morera and contributors.');
        $output->writeln('');
        $output->writeln('Configuration read from ' . $configPath);
        $output->writeln('');
        $output->writeln('');

        $stopwatch = new Stopwatch();
        $stopwatch->start('visithor.go');

        $result = $this->executeVisithor(
            $output,
            $config,
            $format
        );

        $event = $stopwatch->stop('visithor.go');
        $output->writeln('');
        $memory = round($event->getMemory() / 1048576, 2);
        $output->writeln('Time: ' . $event->getDuration() . ' ms, Memory: ' . $memory . 'Mb');
        $output->writeln('');

        $finalMessage = (0 === $result)
            ? '<bg=green> OK </bg=green>'
            : '<bg=red> FAIL </bg=red>';

        $output->writeln($finalMessage);

        return $result;
    }

    /**
     * Executes all business logic inside this command
     *
     * This method returns 0 if all executions passed. 1 otherwise.
     *
     * @param OutputInterface $output Output
     * @param array           $config Config
     * @param string          $format Format
     *
     * @return integer Execution return
     */
    protected function executeVisithor(
        OutputInterface $output,
        array $config,
        $format
    ) {
        $urlGenerator = new UrlGenerator(
            new UrlFactory(),
            new UrlChainFactory()
        );
        $urlChain = $urlGenerator->generate($config);

        $client = new GuzzleClient();
        $rendererFactory = new RendererFactory();
        $renderer = $rendererFactory->create($format);
        $executor = new Executor($client);

        return $executor->execute(
            $urlChain,
            $renderer,
            $output
        );
    }
}
