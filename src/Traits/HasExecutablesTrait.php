<?php


namespace IsaEken\AdvancedPluginSystem\Traits;


use Illuminate\Support\Collection;
use InvalidArgumentException;
use IsaEken\AdvancedPluginSystem\Interfaces\HasExecutablesInterface;
use ReflectionException;
use ReflectionFunction;

/**
 * Trait HasExecutablesTrait
 * @package IsaEken\AdvancedPluginSystem\Traits
 */
trait HasExecutablesTrait
{
    /**
     * @var Collection $customMethods
     */
    public Collection $customMethods;

    /**
     * @return Collection
     */
    public function getCustomMethods() : Collection
    {
        if (!isset($this->customMethods) || $this->customMethods == null) {
            $this->customMethods = collect();
        }

        return $this->customMethods;
    }

    /**
     * Check has method.
     *
     * @param string $name
     * @return bool
     */
    public function hasMethod(string $name) : bool
    {
        return in_array($name, $this->getMethods()) || array_key_exists($name, $this->getMethods());
    }

    /**
     * Get all methods.
     *
     * @return array
     */
    public function getMethods() : array
    {
        return array_merge(get_class_methods(self::class), $this->getCustomMethods()->toArray());
    }

    /**
     * Add method.
     *
     * @param string $name
     * @param callable $callable
     * @return HasExecutablesInterface
     */
    public function addMethod(string $name, callable $callable) : HasExecutablesInterface
    {
        $this->getCustomMethods()->put($name, $callable);

        /** @var HasExecutablesInterface $this */
        return $this;
    }

    /**
     * Remove a method.
     *
     * @param string $name
     * @return HasExecutablesInterface
     */
    public function removeMethod(string $name) : HasExecutablesInterface
    {
        if (!$this->getCustomMethods()->has($name)) {
            throw new InvalidArgumentException("The method \"$name\" is a not exists or a custom method.");
        }

        $this->customMethods = $this->getCustomMethods()->filter(fn($value, $key) => $key != $name);

        /** @var HasExecutablesInterface $this */
        return $this;
    }

    /**
     * Execute a method.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     * @throws ReflectionException
     */
    public function execute(string $name, ...$arguments)
    {
        if (!$this->hasMethod($name)) {
            throw new InvalidArgumentException("The method \"$name\" is not exists in class \"" . self::class . "\"");
        }

        if ($this->getCustomMethods()->has($name)) {
            $method = new ReflectionFunction($this->getCustomMethods()->get($name));
            if (count($arguments) < $method->getNumberOfRequiredParameters()) {
                throw new InvalidArgumentException("Missing arguments in method in \" . $name . \" class \"" . self::class . "\"");
            }
            return $method->invoke(implode(", ", $arguments));
        }

        return call_user_func_array("self::" . $name, $arguments);
    }

    /**
     * Alias of execute function.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     */
    public function call(string $name, ...$arguments)
    {
        return call_user_func_array("self::execute", array_merge([$name], $arguments));
    }

    /**
     * Alias of execute function.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     */
    public function callMethod(string $name, ...$arguments)
    {
        return call_user_func_array("self::execute", array_merge([$name], $arguments));
    }
}
