<?php


namespace IsaEken\AdvancedPluginSystem\Traits;


use Illuminate\Support\Arr;

/**
 * Trait HasVariablesTrait
 * @package IsaEken\AdvancedPluginSystem\Traits
 */
trait HasVariablesTrait
{
    /**
     * Variable collection.
     *
     * @var array $variables
     */
    private array $variables;

    /**
     * Get variables.
     *
     * @return array
     */
    public function getVariables() : array
    {
        if (!isset($this->variables) || $this->variables == null) {
            $this->variables = get_class_vars(self::class);
        }

        return $this->variables;
    }

    /**
     * Check has variable.
     *
     * @param string $name
     * @return bool
     */
    public function hasVariable(string $name) : bool
    {
        return Arr::exists($this->getVariables(), $name);
    }

    /**
     * Get variable.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getVariable(string $name, $default = null)
    {
        if (!$this->hasVariable($name)) {
            return $default;
        }

        return Arr::get($this->getVariables(), $name);
    }

    /**
     * Set variable.
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function setVariable(string $name, $value = null)
    {
        $this->variables = collect($this->getVariables())->put($name, $value)->toArray();
        return $this;
    }

    /**
     * Alias of setVariable()
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function addVariable(string $name, $value = null)
    {
        return $this->setVariable($name, $value);
    }
}
