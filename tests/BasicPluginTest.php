<?php


use PHPUnit\Framework\TestCase;

class BasicPluginTest extends TestCase
{
    public function testLoader()
    {
        $advancedPluginSystem = new IsaEken\AdvancedPluginSystem\AdvancedPluginSystem;
        $advancedPluginSystem->autoloader();

    }
}
