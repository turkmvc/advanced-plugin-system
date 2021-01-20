<?php


namespace IsaEken\AdvancedPluginSystem\Traits;


use Exception;
use Illuminate\Support\Str;
use IsaEken\AdvancedPluginSystem\Models\Plugin;
use IsaEken\AdvancedPluginSystem\Psr4Autoloader;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Trait PluginAutoloadTrait
 * @package IsaEken\AdvancedPluginSystem\Traits
 */
trait PluginAutoloadTrait
{
    /**
     * Autoload plugin
     *
     * @return Plugin
     * @throws ReflectionException
     */
    public function autoload() : Plugin
    {
        $autoload = $this->getAutoload();
        $pluginBasePath = is_file($this->path) ? Str::of($this->path)->replace("/", "\\")->beforeLast("\\")->__toString() : $this->path;
        $psr4Autoloader = new Psr4Autoloader;
        $variables = collect();
        $hooks = collect();

        foreach (isset($autoload['variables']) ? collect($autoload['variables']) : collect() as $class => $file) {
            $path = $pluginBasePath . DIRECTORY_SEPARATOR . $file;
            if (file_exists($path) && is_file($path)) {
                try {
                    @include_once $path;
                    $variables->put($class, @(new $class));
                }
                catch (Exception $exception) {

                }
            }
        }
        foreach (isset($autoload['hooks']) ? collect($autoload['hooks']) : collect() as $class => $file) {
            $path = $pluginBasePath . DIRECTORY_SEPARATOR . $file;
            if (file_exists($path) && is_file($path)) {
                try {
                    @include_once $path;
                    $hooks->put($class, @(new $class));
                }
                catch (Exception $exception) {

                }
            }
        }

        foreach ($variables as $class) {
            $reflection = new ReflectionClass($class);
            foreach ($reflection->getProperties() as $property) {
                if (!$property->isPrivate()) {
                    $name = $property->getName();
                    $value = $class->$name;
                    $this->addVariable($name, $value);
                }
            }
        }
        foreach ($hooks as $class) {
            foreach (get_class_methods($class) as $method) {
                $reflection = new ReflectionMethod($class, $method);
                $callable = function (...$parameters) use ($class, $reflection) {
                    $reflection->invokeArgs($class, $parameters);
                };
                $this->addHook($method, $callable);
            }
        }
        foreach (isset($autoload['psr-4']) ? collect($autoload['psr-4']) : collect() as $class => $path) {
            $fullPath = $pluginBasePath . DIRECTORY_SEPARATOR . $path;
            if (is_dir($fullPath)) {
                $psr4Autoloader->addNamespace($class, $fullPath);
            }
        }
        $psr4Autoloader->register();

        /** @var Plugin $this */
        return $this;
    }
}
