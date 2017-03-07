<?php

namespace TreeHouse\Standards\Tests;

use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use TreeHouse\Standards\CodeQualityChecker;

class CodeQualityCheckerTest extends \PHPUnit_Framework_TestCase
{
    public function testCheckComposer()
    {
        $output  = new BufferedOutput();
        $checker = new CodeQualityChecker($output);

        $result = $checker->checkComposer(['composer.json']);

        $this->assertFalse($result);
        $this->assertContains('composer.json was modified, but the lockfile was not', $output->fetch());
    }

    public function testCheckPhpLint()
    {
        $output  = new BufferedOutput();
        $checker = new CodeQualityChecker($output);

        $result = $checker->checkPhpLint([__DIR__ . '/fixtures/phplint.php']);

        $this->assertFalse($result);
        $this->assertContains('PHP Parse error', $output->fetch());
    }

    public function testCheckPhpCs()
    {
        $output  = new BufferedOutput();
        $output->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);

        $checker = new CodeQualityChecker($output);

        $result = $checker->checkPhpCsFixer([__DIR__ . '/fixtures/phpcs.php']);
        $buffer = $output->fetch();

        $this->assertFalse($result);
        $this->assertContains('Code Style errors found', $buffer);
        $this->assertContains('+ [ \'foo\' => \'bar\' ]  ;', $buffer);
    }
}
