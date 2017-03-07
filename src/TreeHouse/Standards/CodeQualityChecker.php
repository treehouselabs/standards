<?php

namespace TreeHouse\Standards;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;
use PhpCsFixer\Console\Command\FixCommand;
use Webmozart\PathUtil\Path;

class CodeQualityChecker
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @return array
     */
    public function getCommittedFiles()
    {
        $this->output('<comment>Looking for staged files</comment>', OutputInterface::VERBOSITY_VERBOSE);

        $processBuilder = new ProcessBuilder(['git', 'diff', '--cached', '--name-only', '--diff-filter=ACMR']);
        $process = $processBuilder->getProcess();
        $process->run();

        return explode(PHP_EOL, $process->getOutput());
    }

    /**
     * @param string[] $files
     *
     * @return bool
     */
    public function checkComposer(array $files)
    {
        $this->output('<comment>Checking composer lockfile integrity</comment>', OutputInterface::VERBOSITY_VERBOSE);

        if (in_array('composer.json', $files) && !in_array('composer.lock', $files)) {
            $this->output('<error>composer.json was modified, but the lockfile was not. Did you forget to run `composer update`?</error>');

            return false;
        }

        return true;
    }

    /**
     * @param string[] $files
     *
     * @return bool
     */
    public function checkPhpLint(array $files)
    {
        $this->output('<comment>Linting PHP files</comment>', OutputInterface::VERBOSITY_VERBOSE);

        $result = true;

        foreach ($files as $file) {
            if (!preg_match('#\.php$#', $file)) {
                continue;
            }

            $processBuilder = new ProcessBuilder(['php', '-l', $file]);
            $process = $processBuilder->getProcess();
            $process->run();

            if (!$process->isSuccessful()) {
                $this->output($file);
                $this->output(sprintf('<error>%s</error>', trim($process->getErrorOutput())));

                $result = false;
            }
        }

        return $result;
    }

    /**
     * @param string[] $files
     *
     * @return bool
     */
    public function checkPhpCsFixer(array $files)
    {
        $result = true;

        $this->output('<comment>Running CS fixer</comment>', OutputInterface::VERBOSITY_VERBOSE);

        $args = [];

        $rootDir    = $this->getTopLevelDir();
        $configFile = $rootDir . '/.php_cs';

        if (file_exists($configFile)) {
            $args['--config'] = $configFile;
            $result = $this->runPhpCsFixer($args, $rootDir, $result);
        } else {
            $args['--rules'] = '{"array_syntax": {"syntax": "short"}}';

            foreach ($files as $file) {
                if (!preg_match('#\.php$#', $file)) {
                    continue;
                }

                if (!$this->runPhpCsFixer(array_merge($args, ['path' => [$file]]), $rootDir, $result)) {
                    $result = false;
                }
            }
        }

        if (!$result) {
            $this->output('', OutputInterface::VERBOSITY_VERBOSE);
            $this->output('Learn how to set up automatic code-style fixing here:', OutputInterface::VERBOSITY_VERBOSE);
            $this->output('<comment>https://github.com/treehouselabs/standards/blob/master/docs/04-using-phpstorm.md</comment>', OutputInterface::VERBOSITY_VERBOSE);
        }

        return $result;
    }

    /**
     * @param array  $args
     * @param string $rootDir
     * @param bool   $first
     *
     * @return bool
     */
    private function runPhpCsFixer(array $args, $rootDir, $first = true)
    {
        $command = new FixCommand();
        $input   = new ArrayInput(array_merge($args, [
            '--dry-run' => null,
            '--diff'    => null,
            '--format'  => 'json',
        ]));

        $output = new BufferedOutput();
        $output->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);

        if (0 !== $result = $command->run($input, $output)) {
            if ($first) {
                $this->output('');
                $this->output('<error>Code Style errors found:</error>');
            }

            $changes = json_decode($output->fetch(), true);
            foreach ($changes['files'] as $change) {
                $this->output(sprintf('File: <option=bold>%s</>', Path::makeRelative($change['name'], $rootDir)));
                $this->output(['Fixers:'] + $change['appliedFixers'], OutputInterface::VERBOSITY_VERY_VERBOSE);
                $this->output(sprintf("Diff:\n%s", $change['diff']), OutputInterface::VERBOSITY_VERBOSE, OutputInterface::OUTPUT_RAW);
            }

            $this->output('You can fix these errors by running:', OutputInterface::VERBOSITY_VERBOSE);
            $this->output(sprintf('<info>./bin/php-cs-fixer fix %s</info>', $this->getPhpCsFixerCommandLine($args)), OutputInterface::VERBOSITY_VERBOSE);
        }

        return $result === 0;
    }

    /**
     * Returns the top-level git dir
     *
     * @return string
     */
    private function getTopLevelDir()
    {
        $process = new Process('git rev-parse --show-toplevel');
        $process->run();

        return trim($process->getOutput());
    }

    /**
     * @param array $args
     *
     * @return string
     */
    private function getPhpCsFixerCommandLine(array $args)
    {
        unset($args['path']);

        array_walk(
            $args,
            function (&$value, $key) {
                $value = sprintf('%s="%s"', $key, $value);
            }
        );

        return implode(' ', $args);
    }

    /**
     * @param string $message
     * @param int    $threshold
     * @param int    $type
     */
    private function output($message, $threshold = OutputInterface::VERBOSITY_NORMAL, $type = OutputInterface::OUTPUT_NORMAL)
    {
        if ($this->output->getVerbosity() >= $threshold) {
            $this->output->writeln($message, $type);
        }
    }
}
