<?php

namespace Tzsk\Collage\Tests\Helpers;

use Tzsk\Collage\Helpers\Config;
use Tzsk\Collage\Tests\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    protected $config;

    public function setUp(): void
    {
        $this->config = new Config();
    }

    public function test_it_should_have_default_driver()
    {
        $this->assertNotEmpty($this->config->getDriver());
    }

    public function test_default_driver_should_be_gd()
    {
        $this->assertEquals('gd', $this->config->getDriver());
    }

    public function test_it_should_have_a_driver()
    {
        $config = new Config('foo');
        $this->assertEquals('foo', $config->getDriver());

        $config = $config->setDriver('bar');
        $this->assertEquals('bar', $config->getDriver());
    }

    public function test_it_should_have_four_associated_class_map()
    {
        $this->assertCount(4, $this->config->getClassMap());
    }

    public function test_the_class_map_can_be_extended()
    {
        $config = $this->config->setClassMap([1 => 'foo']);
        $this->assertContains('foo', $config->getClassMap());

        $config = $this->config->setClassMap([5 => 'bar']);
        $this->assertContains('bar', $config->getClassMap());

        $this->assertEquals('foo', $config->getGenerator(1));
        $this->assertEquals('bar', $config->getGenerator(5));
    }

    public function test_it_should_have_generators_for_file_count()
    {
        $this->assertTrue($this->config->hasGeneratorFor(1));
        $this->assertTrue($this->config->hasGeneratorFor(2));
        $this->assertTrue($this->config->hasGeneratorFor(3));
        $this->assertTrue($this->config->hasGeneratorFor(4));

        $this->assertFalse($this->config->hasGeneratorFor(0));
        $this->assertFalse($this->config->hasGeneratorFor(5));
    }

    public function test_it_should_have_proper_generator_for_file_count()
    {
        $items = $this->config->getClassMap();

        $this->assertEquals($items[1], $this->config->getGenerator(1));
        $this->assertEquals($items[2], $this->config->getGenerator(2));
        $this->assertEquals($items[3], $this->config->getGenerator(3));
        $this->assertEquals($items[4], $this->config->getGenerator(4));
    }
}
