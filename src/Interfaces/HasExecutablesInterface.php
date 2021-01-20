<?php


namespace IsaEken\AdvancedPluginSystem\Interfaces;


/**
 * Interface HasExecutablesInterface
 * @package IsaEken\AdvancedPluginSystem\Interfaces
 */
interface HasExecutablesInterface
{
    /**
     * Check has method.
     *
     * @param string $name
     * @return bool
     */
    public function hasMethod(string $name) : bool;

    /**
     * Get all methods.
     *
     * @return array
     */
    public function getMethods() : array;

    /**
     * Add method.
     *
     * @param string $name
     * @param callable $callable
     * @return HasExecutablesInterface
     */
    public function addMethod(string $name, callable $callable) : HasExecutablesInterface;

    /**
     * Remove a method.
     *
     * @param string $name
     * @return HasExecutablesInterface
     */
    public function removeMethod(string $name) : HasExecutablesInterface;

    /**
     * Execute a method.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     */
    public function execute(string $name, ...$arguments);

    /**
     * Alias of execute function.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     */
    public function call(string $name, ...$arguments);

    /**
     * Alias of execute function.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     */
    public function callMethod(string $name, ...$arguments);
}
