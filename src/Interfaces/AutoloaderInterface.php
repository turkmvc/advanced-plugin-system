<?php


namespace IsaEken\AdvancedPluginSystem\Interfaces;


use IsaEken\AdvancedPluginSystem\Models\Plugin;

/**
 * Interface AutoloaderInterface
 * @package IsaEken\AdvancedPluginSystem\Interfaces
 */
interface AutoloaderInterface
{
    /**
     * Get autoloader file extension
     *
     * @return string
     */
    public static function getExtension() : string;

    /**
     * AutoloaderInterface constructor.
     *
     * @param string $path
     */
    public function __construct(string $path);

    /**
     * Get the plugin
     *
     * @return Plugin
     */
    public function getPlugin() : Plugin;
}
