<?php


namespace IsaEken\AdvancedPluginSystem\Interfaces;


/**
 * Interface HasVariablesInterface
 * @package IsaEken\AdvancedPluginSystem\Interfaces
 */
interface HasVariablesInterface
{
    /**
     * Get variables.
     *
     * @return array
     */
    public function getVariables() : array;

    /**
     * Check has variable.
     *
     * @param string $name
     * @return bool
     */
    public function hasVariable(string $name) : bool;

    /**
     * Get variable.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getVariable(string $name, $default = null);

    /**
     * Set variable.
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function setVariable(string $name, $value = null);

    /**
     * Alias of setVariable()
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function addVariable(string $name, $value = null);
}
