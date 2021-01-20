<?php


namespace IsaEken\AdvancedPluginSystem\Traits;


use IsaEken\AdvancedPluginSystem\AdvancedPluginSystem;
use IsaEken\AdvancedPluginSystem\Models\Plugin;

/**
 * Trait HasPluginStatesTrait
 * @package IsaEken\AdvancedPluginSystem\Traits
 */
trait HasPluginStatesTrait
{
    /**
     * @var bool|null $cachedState
     */
    private ?bool $cachedState = null;

    /**
     * Check plugin is enabled.
     *
     * @return bool
     */
    public function isEnabled() : bool
    {
        if ($this->cachedState === null) {
            /** @var AdvancedPluginSystem $advancedPluginSystem */
            $advancedPluginSystem = $this->advancedPluginSystem;
            $enabledPlugins = $advancedPluginSystem->hasData("enabledPlugins") ? $advancedPluginSystem->getData("enabledPlugins") : [];
            $value = true;

            foreach ($enabledPlugins as $enabledPluginId => $state) {
                if ($enabledPluginId == $this->getId()) {
                    $value = boolval($state);
                    break;
                }
            }

            $this->cachedState = $value;
        }

        return $this->cachedState;
    }

    /**
     * Check plugin is disabled.
     *
     * @return bool
     */
    public function isDisabled() : bool
    {
        return !$this->isEnabled();
    }

    /**
     * Enable the plugin.
     *
     * @return Plugin
     */
    public function enable() : Plugin
    {
        /** @var AdvancedPluginSystem $advancedPluginSystem */
        $advancedPluginSystem = $this->advancedPluginSystem;
        $enabledPlugins = $advancedPluginSystem->hasData("enabledPlugins") ? (array) $advancedPluginSystem->getData("enabledPlugins") : [];
        $this->cachedState = $enabledPlugins[$this->getId()] = true;
        $advancedPluginSystem->setData("enabledPlugins", $enabledPlugins)->writeDataFile();

        /** @var Plugin $this */
        return $this;
    }

    /**
     * Disable the plugin.
     *
     * @return Plugin
     */
    public function disable() : Plugin
    {
        /** @var AdvancedPluginSystem $advancedPluginSystem */
        $advancedPluginSystem = $this->advancedPluginSystem;
        $enabledPlugins = $advancedPluginSystem->hasData("enabledPlugins") ? (array) $advancedPluginSystem->getData("enabledPlugins") : [];
        $this->cachedState = $enabledPlugins[$this->getId()] = false;
        $advancedPluginSystem->setData("enabledPlugins", $enabledPlugins)->writeDataFile();

        /** @var Plugin $this */
        return $this;
    }

    /**
     * Toggle enable or disable plugin state.
     *
     * @return Plugin
     */
    public function toggle() : Plugin
    {
        if ($this->isEnabled()) {
            return $this->disable();
        }
        else {
            return $this->enable();
        }
    }
}
