<?php

namespace TreeHouse\Standards\Tests;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\Output;
use TreeHouse\Standards\CodeQualityChecker;

class CodeQualityCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CodeQualityChecker|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $checker;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->checker = $this->getMockBuilder(CodeQualityChecker::class)->setMethods(['getCommittedFiles'])->getMock();
    }

    public function testCheckComposer()
    {
        $input  = new ArrayInput(['name' => 'code-qa']);
        $output = new TestOutput();

        $files = [
            'composer.json',
        ];

        $this->checker->expects($this->once())->method('getCommittedFiles')->will($this->returnValue($files));
        $exitCode = $this->checker->doRun($input, $output);

        $this->assertEquals(1, $exitCode);
        $this->assertContains('composer.json was modified, but the lockfile was not', $output->output);
    }

    public function testCheckPhpLint()
    {
        $input  = new ArrayInput(['name' => 'code-qa']);
        $output = new TestOutput();

        $files = [
            __DIR__ . '/fixtures/phplint.php',
        ];

        $this->checker->expects($this->once())->method('getCommittedFiles')->will($this->returnValue($files));
        $exitCode = $this->checker->doRun($input, $output);

        $this->assertEquals(1, $exitCode);
        $this->assertContains('PHP Parse error', $output->output);
    }

    public function testCheckPhpCs()
    {
        $input  = new ArrayInput(['name' => 'code-qa']);
        $output = new TestOutput();

        $files = [
            __DIR__ . '/fixtures/phpcs.php',
        ];

        $this->checker->expects($this->once())->method('getCommittedFiles')->will($this->returnValue($files));
        $exitCode = $this->checker->doRun($input, $output);

        $this->assertEquals(1, $exitCode);
        $this->assertContains('function_call_space', $output->output);
    }
}

/**
 * @private
 */
class TestOutput extends Output
{
    public $output = '';

    public function clear()
    {
        $this->output = '';
    }

    protected function doWrite($message, $newline)
    {
        $this->output .= $message.($newline ? "\n" : '');
    }
}
