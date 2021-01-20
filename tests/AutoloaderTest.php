<?php


use PHPUnit\Framework\TestCase;

class AutoloaderTest extends TestCase
{
    public function testAutoloader()
    {
        $advancedPluginSystem = new IsaEken\AdvancedPluginSystem\AdvancedPluginSystem;
        $advancedPluginSystem->autoload(__DIR__ . "/../examples");
        $this->assertTrue(count($advancedPluginSystem->plugins) > 0);
    }

    public function testAutoloaderWithoutNested()
    {
        $advancedPluginSystem = new IsaEken\AdvancedPluginSystem\AdvancedPluginSystem;
        $advancedPluginSystem->autoload(__DIR__ . "/../examples", ['nested' => false]);
        $this->assertTrue(count($advancedPluginSystem->plugins) > 0);
    }
}
