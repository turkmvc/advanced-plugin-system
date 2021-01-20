<?php


namespace IsaEken\AdvancedPluginSystem\Interfaces;


use IsaEken\AdvancedPluginSystem\Models\Plugin;

/**
 * Interface PluginStateInterface
 * @package IsaEken\AdvancedPluginSystem\Interfaces
 */
interface PluginStateInterface
{
    /**
     * Check plugin is enabled.
     *
     * @return bool
     */
    public function isEnabled() : bool;

    /**
     * Check plugin is disabled.
     *
     * @return bool
     */
    public function isDisabled() : bool;

    /**
     * Enable the plugin.
     *
     * @return Plugin
     */
    public function enable() : Plugin;

    /**
     * Disable the plugin.
     *
     * @return Plugin
     */
    public function disable() : Plugin;

    /**
     * Toggle enable or disable plugin state.
     *
     * @return Plugin
     */
    public function toggle() : Plugin;
}
