<?php

namespace IsaEken\AdvancedPluginSystem\Test;

use IsaEken\AdvancedPluginSystem\Helpers;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testNames()
    {
        $this->assertTrue(Helpers::isName("isaeken/advanced-plugin-system"));
        $this->assertFalse(Helpers::isName("thisIsInvalidPackageName"));
    }

    public function testVersions()
    {
        $this->assertTrue(Helpers::isVersion("1.0.0-beta"));
        $this->assertFalse(Helpers::isVersion("thisIsInvalidVersion"));
    }

    public function testIsPackage()
    {
        $this->assertTrue(Helpers::isPackage("isaeken/advanced-plugin-system", "1.0.0-beta"));
        $this->assertFalse(Helpers::isPackage("thisIsInvalidName", "1.0.0-beta"));
        $this->assertFalse(Helpers::isPackage("isaeken/advanced-plugin-system", "thisIsInvalidVersion"));
        $this->assertFalse(Helpers::isPackage("thisIsInvalidName", "thisIsInvalidVersion"));
    }

    public function testVersion()
    {
        $mock = (object) [
            "version" => "1.0.0-beta",
            "isValid" => true,
            "major" => 1,
            "minor" => 0,
            "patch" => 0,
            "prerelease" => "beta",
            "buildmetadata" => null,
        ];
        $this->assertEquals(Helpers::version("1.0.0-beta"), $mock);
        $this->assertNotEquals(Helpers::version("thisIsInvalidVersion"), $mock);
    }

    public function testBooleanFromVar()
    {
        $this->assertTrue(Helpers::booleanFromVar(true));
        $this->assertTrue(Helpers::booleanFromVar("true"));
        $this->assertTrue(Helpers::booleanFromVar("yes"));
        $this->assertTrue(Helpers::booleanFromVar("ok"));
        $this->assertTrue(Helpers::booleanFromVar(1));

        $this->assertFalse(Helpers::booleanFromVar(false));
        $this->assertFalse(Helpers::booleanFromVar("false"));
        $this->assertFalse(Helpers::booleanFromVar("no"));
        $this->assertFalse(Helpers::booleanFromVar("null"));
        $this->assertFalse(Helpers::booleanFromVar(0));
        $this->assertFalse(Helpers::booleanFromVar(-1));
    }
}
