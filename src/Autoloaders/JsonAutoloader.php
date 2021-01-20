<?php


namespace IsaEken\AdvancedPluginSystem\Autoloaders;


use Illuminate\Support\Str;
use IsaEken\AdvancedPluginSystem\Enums\PluginType;
use IsaEken\AdvancedPluginSystem\Exceptions\InvalidVersionException;
use IsaEken\AdvancedPluginSystem\Interfaces\AutoloaderInterface;
use IsaEken\AdvancedPluginSystem\Models\Plugin;

class JsonAutoloader implements AutoloaderInterface
{
    use BaseAutoloaderTrait;

    /**
     * @var Plugin|null $plugin
     */
    public ?Plugin $plugin = null;

    /**
     * Get autoloader file extension
     *
     * @return string
     */
    public static function getExtension() : string
    {
        return "JSON";
    }

    /**
     * @param string $path
     * @return bool
     */
    public static function isValid(string $path) : bool
    {
        $path = implode(DIRECTORY_SEPARATOR, [$path, basename($path) . "." . self::getExtension()]);
        return file_exists($path) && is_file($path) && Str::endsWith(strtolower($path), strtolower(self::getExtension()));
    }

    /**
     * AutoloaderInterface constructor.
     *
     * @param string $path
     * @throws InvalidVersionException
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->configuration = json_decode(file_get_contents($this->getFilepath()), true);
        $this->getPlugin();
    }

    /**
     * @param string|null $path
     * @return string
     */
    public function getFilepath(string $path = null) : string
    {
        if ($path == null) {
            $path = $this->path;
        }

        return implode(DIRECTORY_SEPARATOR, [$path, basename($path) . "." . self::getExtension()]);
    }

    /**
     * Load plugin method
     *
     * @throws InvalidVersionException
     * @return Plugin
     */
    public function getPlugin() : Plugin
    {
        if ($this->plugin == null) {
            $this->plugin = new Plugin($this->configuration);
            $this->plugin->pluginType = PluginType::Autoloader;
        }

        return $this->plugin;
    }
}
