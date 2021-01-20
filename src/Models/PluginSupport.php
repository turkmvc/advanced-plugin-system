<?php


namespace IsaEken\AdvancedPluginSystem\Models;


use IsaEken\AdvancedPluginSystem\Interfaces\PluginSupportInterface;

/**
 * Class PluginSupport
 * @package IsaEken\AdvancedPluginSystem\Models
 * @property string $email
 * @property string $docs
 * @property string $forum
 * @property string $irc
 * @property string $issues
 * @property string $rss
 * @property string $source
 * @property string $wiki
 */
class PluginSupport implements PluginSupportInterface
{
    /**
     * Variables array.
     *
     * @var array $variables
     */
    private array $variables = [];

    /**
     * PluginSupport constructor.
     *
     * @param array $variables
     */
    public function __construct(array $variables)
    {
        $defaults = ["email" => "", "docs" => "", "forum" => "", "irc" => "", "issues" => "", "rss" => "", "source" => "", "wiki" => ""];
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
     * Plugin support email address
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->__get("email");
    }

    /**
     * Plugin support docs address
     *
     * @return string
     */
    public function getDocs() : string
    {
        return $this->__get("docs");
    }

    /**
     * Plugin support forum address
     *
     * @return string
     */
    public function getForum() : string
    {
        return $this->__get("forum");
    }

    /**
     * Plugin support irc address
     *
     * @return string
     */
    public function getIrc() : string
    {
        return $this->__get("irc");
    }

    /**
     * Plugin support issues address
     *
     * @return string
     */
    public function getIssues() : string
    {
        return $this->__get("issues");
    }

    /**
     * Plugin support rss address
     *
     * @return string
     */
    public function getRss() : string
    {
        return $this->__get("rss");
    }

    /**
     * Plugin support source address
     *
     * @return string
     */
    public function getSource() : string
    {
        return $this->__get("source");
    }

    /**
     * Plugin support wiki address
     *
     * @return string
     */
    public function getWiki() : string
    {
        return $this->__get("wiki");
    }
}
