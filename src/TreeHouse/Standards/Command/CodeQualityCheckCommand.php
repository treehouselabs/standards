<?php

namespace TreeHouse\Standards\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TreeHouse\Standards\CodeQualityChecker;

class CodeQualityCheckCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('code:qa:check');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>' . $this->getApplication()->getLongVersion() . '</info>');

        $checker = new CodeQualityChecker($output);
        $files   = $checker->getCommittedFiles();

        $checks = [
            'composer' => 'checkComposer',
            'phplint'  => 'checkPhpLint',
            'phpcs'    => 'checkPhpCsFixer',
        ];

        $result = 0;
        foreach ($checks as $name => $method) {
            if (false === $checker->$method($files)) {
                $result = 1;
            }
        }

        return $result;
    }
}
