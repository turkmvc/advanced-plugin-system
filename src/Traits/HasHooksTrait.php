<?php


namespace IsaEken\AdvancedPluginSystem\Traits;


use InvalidArgumentException;
use IsaEken\AdvancedPluginSystem\Interfaces\HasHooksInterface;
use ReflectionException;
use ReflectionFunction;
use stdClass;

/**
 * Trait HasHooksTrait
 * @package IsaEken\AdvancedPluginSystem\Traits
 */
trait HasHooksTrait
{
    /**
     * @var array $hooks
     */
    private array $hooks;

    /**
     * Get all hooks.
     *
     * @return array
     */
    public function getHooks() : array
    {
        if (!isset($this->hooks) || $this->hooks == null) {
            $this->hooks = [];
        }

        return $this->hooks;
    }

    /**
     * Check has hook exists.
     *
     * @param string $name
     * @return bool
     */
    public function hasHook(string $name) : bool
    {
        return collect($this->getHooks())->has($name);
    }

    /**
     * Add hook.
     *
     * @param string $name
     * @param callable $callable
     * @return HasHooksInterface
     */
    public function addHook(string $name, callable $callable) : HasHooksInterface
    {
        $this->hooks = collect($this->getHooks())->put($name, $callable)->toArray();

        /** @var HasHooksInterface $this */
        return $this;
    }

    /**
     * Alias of addHook()
     *
     * @param string $name
     * @param callable $callable
     * @return HasHooksInterface
     */
    public function setHook(string $name, callable $callable) : HasHooksInterface
    {
        return $this->addHook($name, $callable);
    }

    /**
     * Remove a hook.
     *
     * @param string $name
     * @return HasHooksInterface
     */
    public function removeHook(string $name) : HasHooksInterface
    {
        $this->hooks = collect($this->getHooks())->filter(fn($value, $key) => $key != $name)->toArray();

        /** @var HasHooksInterface $this */
        return $this;
    }

    /**
     * Get hook information.
     *
     * @param string $name
     * @return object
     * @throws ReflectionException
     */
    public function getHook(string $name) : object
    {
        if (!$this->hasHook($name)) {
            return new stdClass;
        }

        $reflection = new ReflectionFunction(collect($this->hooks)->get($name));
        $hook = new stdClass;

        $hook->name = $name;
        $hook->closure = $reflection->getClosure();
        $hook->namespace = $reflection->getNamespaceName();
        $hook->returnType = $reflection->getReturnType();
        $hook->parameters = $reflection->getParameters();
        $hook->numberOfParameters = $reflection->getNumberOfParameters();
        $hook->numberOfRequiredParameters = $reflection->getNumberOfRequiredParameters();

        $hook->filename = $reflection->getFileName();
        $hook->startLine = $reflection->getStartLine();
        $hook->endLine = $reflection->getEndLine();

        $hook->reflection = $reflection;

        return $hook;
    }

    /**
     * Execute a hook.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     * @throws ReflectionException
     */
    public function executeHook(string $name, ...$arguments)
    {
        if (!$this->hasHook($name)) {
            throw new InvalidArgumentException("The hook \"" . $name . "\" is not exists in \"" . self::class . "\"");
        }

        $hook = $this->getHook($name);

        if ($hook->numberOfRequiredParameters > count($arguments)) {
            throw new InvalidArgumentException("Missing arguments in hook \"" . $name . "\"");
        }

        /** @var ReflectionFunction $reflection */
        $reflection = $hook->reflection;

        return $reflection->invokeArgs($arguments);
    }

    /**
     * Alias of executeHook()
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     */
    public function callHook(string $name, ...$arguments)
    {
        return call_user_func_array("self::executeHook", func_get_args());
    }

    /**
     * Alias of executeHook()
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     */
    public function hook(string $name, ...$arguments)
    {
        return call_user_func_array("self::executeHook", func_get_args());
    }
}
