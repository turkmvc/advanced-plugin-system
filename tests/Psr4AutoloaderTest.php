<?php

namespace IsaEken\AdvancedPluginSystem\Test;

use IsaEken\AdvancedPluginSystem\Psr4Autoloader;
use PHPUnit\Framework\TestCase;

class Psr4AutoloaderTest extends TestCase
{
    public function testAutoloader()
    {
        $autoloader = new Psr4Autoloader();
        $autoloader->addNamespace("AdvancedPluginSystem\\\\AdvancedPlugin\\\\", __DIR__ . "/../examples/AdvancedPlugin/src");
        $autoloader->register();
        $this->assertInstanceOf(\AdvancedPluginSystem\AdvancedPlugin\AdvancedPlugin::class, new \AdvancedPluginSystem\AdvancedPlugin\AdvancedPlugin);
    }
}
