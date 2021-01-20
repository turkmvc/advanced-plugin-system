<?php


namespace IsaEken\AdvancedPluginSystem\Interfaces;


/**
 * Interface HasHooksInterface
 * @package IsaEken\AdvancedPluginSystem\Interfaces
 */
interface HasHooksInterface
{
    /**
     * Get all hooks.
     *
     * @return array
     */
    public function getHooks() : array;

    /**
     * Check has hook exists.
     *
     * @param string $name
     * @return bool
     */
    public function hasHook(string $name) : bool;

    /**
     * Add hook.
     *
     * @param string $name
     * @param callable $callable
     * @return HasHooksInterface
     */
    public function addHook(string $name, callable $callable) : HasHooksInterface;

    /**
     * Alias of addHook()
     *
     * @param string $name
     * @param callable $callable
     * @return HasHooksInterface
     */
    public function setHook(string $name, callable $callable) : HasHooksInterface;

    /**
     * Remove a hook.
     *
     * @param string $name
     * @return HasHooksInterface
     */
    public function removeHook(string $name) : HasHooksInterface;

    /**
     * Get hook information.
     *
     * @param string $name
     * @return object
     */
    public function getHook(string $name) : object;

    /**
     * Execute a hook.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     */
    public function executeHook(string $name, ...$arguments);

    /**
     * Alias of executeHook()
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     */
    public function callHook(string $name, ...$arguments);

    /**
     * Alias of executeHook()
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     */
    public function hook(string $name, ...$arguments);
}
