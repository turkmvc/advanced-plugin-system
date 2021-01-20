<?php


namespace IsaEken\AdvancedPluginSystem\Models;


use IsaEken\AdvancedPluginSystem\Interfaces\PluginAuthorInterface;

/**
 * Class PluginAuthor
 * @package IsaEken\AdvancedPluginSystem\Models
 * @property string $name
 * @property string $email
 * @property string $homepage
 * @property string $role
 */
class PluginAuthor implements PluginAuthorInterface
{
    /**
     * Variables array.
     *
     * @var array $variables
     */
    private array $variables = [];

    /**
     * PluginAuthor constructor.
     *
     * @param array $variables
     */
    public function __construct(array $variables)
    {
        $defaults = ["name" => "", "email" => "", "homepage" => "", "role" => ""];
        $this->variables = array_merge($defaults, $variables);
    }

    /**
     * Get a variable.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (in_array($name, $this->variables)) {
            return $this->variables[$name];
        }

        return $this->$name;
    }

    /**
     * Set a variable.
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /**
     * Get the full name of plugin author.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->__get("name");
    }

    /**
     * Get the email address of plugin author.
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->__get("email");
    }

    /**
     * Get the homepage address of plugin author.
     *
     * @return string
     */
    public function getHomepage() : string
    {
        return $this->__get("homepage");
    }

    /**
     * Get the role.
     *
     * @return string
     */
    public function getRole() : string
    {
        return $this->__get("role");
    }
}
