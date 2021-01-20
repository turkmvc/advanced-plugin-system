<?php


namespace IsaEken\AdvancedPluginSystem;


use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use IsaEken\AdvancedPluginSystem\Interfaces\HasHooksInterface;
use IsaEken\AdvancedPluginSystem\Traits\AutoloaderTrait;
use IsaEken\AdvancedPluginSystem\Traits\HasDataFileTrait;

/**
 * Class AdvancedPluginSystem
 * @package IsaEken\AdvancedPluginSystem
 */
class AdvancedPluginSystem
{
    use AutoloaderTrait;
    use HasDataFileTrait;

    /**
     * @var string $dataFile
     */
    protected static string $dataFile = __DIR__ . "/../" . "/data.json";

    /**
     * Plugins collection.
     *
     * @var Collection $plugins
     */
    public Collection $plugins;

    /**
     * Enabled plugins collection.
     *
     * @var Collection $enabledPlugins
     */
    public Collection $enabledPlugins;

    /**
     * Disabled plugins collection.
     *
     * @var Collection $disabledPlugins
     */
    public Collection $disabledPlugins;

    /**
     * Plugin hooks collection.
     *
     * @var Collection $hooks
     */
    public Collection $hooks;

    /**
     * AdvancedPluginSystem constructor.
     */
    public function __construct()
    {
        // ...
    }

    /**
     * Get all hooks.
     *
     * @param bool $forceUpdate
     * @return Collection
     */
    public function getHooks(bool $forceUpdate = false) : Collection
    {
        if (!isset($this->hooks) || $this->hooks == null || $forceUpdate) {
            $this->hooks = collect();

            foreach ($this->enabledPlugins as $enabledPlugin) {
                if ($enabledPlugin instanceof HasHooksInterface) {
                    foreach ($enabledPlugin->getHooks() as $name => $closure) {
                        $this->hooks->put($name, $name);
                    }
                }
            }
        }

        return $this->hooks;
    }

    /**
     * Check has hook exists.
     *
     * @param string $name
     * @param bool $forceUpdate
     * @return bool
     */
    public function hasHook(string $name, bool $forceUpdate = false) : bool
    {
        return $this->getHooks($forceUpdate)->has($name);
    }

    /**
     * Call hook in all enabled plugins.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return object
     */
    public function callHook(string $name, ...$arguments) : object
    {
        $successes = collect();
        $exceptions = collect();

        if (!$this->hasHook($name)) {
            throw new \InvalidArgumentException("The hook \"" . $name . "\" is not exists.");
        }

        foreach ($this->enabledPlugins as $enabledPlugin) {
            if ($enabledPlugin instanceof HasHooksInterface) {
                if ($enabledPlugin->hasHook($name)) {
                    try {
                        $reflection = new \ReflectionMethod($enabledPlugin, "hook");
                        $reflection->invokeArgs($enabledPlugin, func_get_args());
                        $successes->add($enabledPlugin->getId());
                    }
                    catch (Exception $exception) {
                        $exceptions->add($exception);
                    }
                }
            }
        }

        return (object) [
            "successes" => $successes,
            "exceptions" => $exceptions,
        ];
    }

    /**
     * [ EXPERIMENTAL ]
     * Call all hooks in enabled plugins.
     *
     * @param mixed ...$arguments
     * @return object
     */
    public function callHooks(...$arguments) : object
    {
        $successes = collect();
        $exceptions = collect();

        foreach ($this->getHooks() as $hook) {
            $execute = call_user_func("self::callHook", $hook, func_get_args());
            foreach ($execute->successes as $success) { $successes->add($success); }
            foreach ($execute->exceptions as $exception) { $exceptions->add($exception); }
        }

        return (object) [
            "successes" => $successes,
            "exceptions" => $exceptions,
        ];
    }

    /**
     * Generate id for plugins using name and optionally version.
     *
     * @param string $name
     * @param string|null $version
     * @return string
     */
    public static function createPluginId(string $name, ?string $version = null) : string
    {
        $name = Str::of($name)->replace("/", "@");
        $version = Str::of($version);

        $id = Str::of($name);
        if ($version->length() > 0) {
            $id = $id->append("." . $version);
        }

        return $id->lower()->__toString();
    }

    /**
     * Check plugin hash id using name and optionally version.
     *
     * @param string $id
     * @param string $name
     * @param string|null $version
     * @return bool
     */
    public static function diffPluginId(string $id, string $name, ?string $version = null) : bool
    {
        return $id == self::createPluginId($name, $version);
    }
}
