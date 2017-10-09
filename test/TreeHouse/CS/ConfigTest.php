<?php

declare(strict_types=1);

namespace Test\TreeHouse\CS;

use PhpCsFixer\ConfigInterface;
use PHPUnit\Framework\TestCase;
use TreeHouse\CS\Config;

class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->config = new Config();
    }

    /**
     * @test
     */
    public function it_implements_interface()
    {
        $this->assertInstanceOf(
            ConfigInterface::class,
            $this->config
        );
    }

    /**
     * @test
     */
    public function it_uses_cache()
    {
        $this->assertTrue(
            $this->config->getUsingCache()
        );
    }

    /**
     * @test
     */
    public function it_allows_risky_tests_by_default()
    {
        $this->assertTrue(
            $this->config->getRiskyAllowed()
        );
    }

    /**
     * @test
     */
    public function it_uses_symfony_conventions_by_default()
    {
        $this->assertContains(
            '@Symfony',
            $this->config->getRules()
        );
    }

    /**
     * @test
     */
    public function it_uses_risky_symfony_fixers_by_default()
    {
        $this->assertContains(
            '@Symfony:risky',
            $this->config->getRules()
        );
    }
}
