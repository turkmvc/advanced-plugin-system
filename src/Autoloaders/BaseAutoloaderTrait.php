<?php


namespace IsaEken\AdvancedPluginSystem\Autoloaders;


use IsaEken\AdvancedPluginSystem\AdvancedPluginSystem;

/**
 * Trait BaseAutoloaderTrait
 * @package IsaEken\AdvancedPluginSystem\Autoloaders
 */
trait BaseAutoloaderTrait
{
    /**
     * @var AdvancedPluginSystem|null $advancedPluginSystem
     */
    public ?AdvancedPluginSystem $advancedPluginSystem = null;

    /**
     * @var string $path
     */
    public string $path;

    /**
     * @var array $configuration
     */
    public array $configuration = [];
}
