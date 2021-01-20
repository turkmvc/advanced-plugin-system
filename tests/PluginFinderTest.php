<?php

namespace IsaEken\AdvancedPluginSystem\Test;

use IsaEken\AdvancedPluginSystem\PluginFinder;
use PHPUnit\Framework\TestCase;

class PluginFinderTest extends TestCase
{
    public function testFinder()
    {
        $pluginFinder = new PluginFinder(__DIR__ . "/../examples");
        $this->assertTrue(count($pluginFinder->find()->plugins) > 0);
    }

    public function testFinderWithoutNested()
    {
        $pluginFinder = new PluginFinder(__DIR__ . "/../examples", ['nested' => false]);
        $this->assertTrue(count($pluginFinder->find()->plugins) < 2);
    }
}
