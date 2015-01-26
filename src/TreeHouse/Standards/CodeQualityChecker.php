<?php

namespace TreeHouse\Standards;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Console\Application;

class CodeQualityChecker extends Application
{
    /**
     * @var string
     */
    protected $binDir;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct('Code Quality Checker', '1.0.0');

        $this->getDefinition()->addOption(
            new InputOption('--bin-dir', '-b', InputOption::VALUE_OPTIONAL, 'The directory to look for binaries', 'bin')
        );
    }

    /**
     * @inheritdoc
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $input->bind($this->getDefinition());

        $this->input  = $input;
        $this->output = $output;

        $this->binDir = rtrim($this->input->getOption('bin-dir'), '/');

        $this->output('TreeHouse code quality checker', OutputInterface::VERBOSITY_VERBOSE);
        $this->output('Looking for staged files', OutputInterface::VERBOSITY_VERY_VERBOSE);

        $files = $this->getCommittedFiles();

        $checks = [
            'composer' => 'checkComposer',
            'phplint'  => 'lintPhp',
            'phpcs'    => 'runPhpCsFixer',
        ];

        $result = 0;
        foreach ($checks as $name => $method) {
            if (false === $this->$method($files)) {
                $result = 1;
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getCommittedFiles()
    {
        $processBuilder = new ProcessBuilder(['git', 'diff', '--cached', '--name-only', '--diff-filter=ACMR']);
        $process = $processBuilder->getProcess();
        $process->run();

        return explode(PHP_EOL, $process->getOutput());
    }

    /**
     * @param string[] $files
     *
     * @return boolean
     */
    protected function checkComposer(array $files)
    {
        if (in_array('composer.json', $files) && !in_array('composer.lock', $files)) {
            $this->output->writeln(
                '<error>composer.json was modified, but the lockfile was not. Did you forget to run `composer update`?</error>'
            );

            return false;
        }

        return true;
    }

    /**
     * @param string[] $files
     *
     * @return boolean
     */
    protected function lintPhp(array $files)
    {
        $result = true;

        foreach ($files as $file) {
            if (!preg_match('#\.php$#', $file)) {
                continue;
            }

            $processBuilder = new ProcessBuilder(['php', '-l', $file]);
            $process = $processBuilder->getProcess();
            $process->run();

            if (!$process->isSuccessful()) {
                $this->output->writeln($file);
                $this->output->writeln(sprintf('<error>%s</error>', trim($process->getErrorOutput())));

                $result = false;
            }
        }

        return $result;
    }

    /**
     * @param string[] $files
     *
     * @return boolean
     */
    protected function runPhpCsFixer(array $files)
    {
        $result = true;

        foreach ($files as $file) {
            if (!preg_match('#\.php$#', $file)) {
                continue;
            }

            $processBuilder = new ProcessBuilder([
                'php',
                $this->binDir . '/php-cs-fixer',
                'fix',
                '--dry-run',
                '--verbose',
                '--level=symfony',
                '--fixers=-empty_return,-concat_without_spaces',
                $file,
            ]);

            $processBuilder->setWorkingDirectory(__DIR__ . '/../../../');
            $phpCsFixer = $processBuilder->getProcess();
            $phpCsFixer->run();

            if (!$phpCsFixer->isSuccessful()) {
                $this->output->writeln(sprintf('<error>%s</error>', trim($phpCsFixer->getOutput())));

                $result = false;
            }
        }

        return $result;
    }

    /**
     * @param string  $message
     * @param integer $threshold
     */
    private function output($message, $threshold)
    {
        if ($this->output->getVerbosity() >= $threshold) {
            $this->output->writeln($message);
        }
    }
}
