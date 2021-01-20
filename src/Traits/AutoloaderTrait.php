<?php


namespace IsaEken\AdvancedPluginSystem\Traits;


use IsaEken\AdvancedPluginSystem\AdvancedPluginSystem;
use IsaEken\AdvancedPluginSystem\Exceptions\DirectoryNotFoundException;
use IsaEken\AdvancedPluginSystem\Models\Plugin;
use IsaEken\AdvancedPluginSystem\PluginFinder;
use ReflectionException;

/**
 * Trait AutoloaderTrait
 * @package IsaEken\AdvancedPluginSystem\Traits
 */
trait AutoloaderTrait
{
    /**
     * @var string $path
     */
    public string $path;

    /**
     * @var bool $nested
     */
    public bool $nested = true;

    /**
     * Automatically load plugins
     *
     * @param string $path
     * @param array $options
     * @return AdvancedPluginSystem
     * @throws DirectoryNotFoundException
     * @throws ReflectionException
     */
    public function autoload(string $path, array $options = []) : AdvancedPluginSystem
    {
        $this->path = $path;

        if (!is_dir($this->path)) {
            throw new DirectoryNotFoundException;
        }

        foreach ($options as $key => $value) {
            if (isset($this->$$key)) {
                $this->$$key = $value;
            }
        }

        $pluginFinder = new PluginFinder($this->path, [
            'nested' => $this->nested,
        ]);

        /** @var AdvancedPluginSystem $this */
        $pluginFinder->advancedPluginSystem = $this;

        $pluginFinder->find();

        $this->plugins = collect();
        $this->enabledPlugins = collect();
        $this->disabledPlugins = collect();

        /**
         * @var string $pluginName
         * @var Plugin $plugin
         */
        foreach ($pluginFinder->plugins as $pluginName => $plugin) {
            $this->plugins->put($plugin->getName(), $plugin);

            if ($plugin->isEnabled()) {
                $this->enabledPlugins->put($plugin->getName(), $plugin);
                $plugin->autoload();
            }
            else {
                $this->disabledPlugins->put($plugin->getName(), $plugin);
            }
        }

        /** @var AdvancedPluginSystem $this */
        return $this;
    }
}
