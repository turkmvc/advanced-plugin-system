<?php


namespace IsaEken\AdvancedPluginSystem\Interfaces;


use IsaEken\AdvancedPluginSystem\Models\PluginSupport;

/**
 * Interface PluginInterface
 * @package IsaEken\AdvancedPluginSystem\Interfaces
 */
interface PluginInterface
{
    /**
     * Plugin name
     *
     * @return string
     */
    public function getName() : string;

    /**
     * Plugin version
     *
     * @return string
     */
    public function getVersion() : string;

    /**
     * Plugin id
     *
     * @return string
     */
    public function getId() : string;

    /**
     * Plugin description
     *
     * @return string
     */
    public function getDescription() : string;

    /**
     * Plugin keywords
     *
     * @return string[]
     */
    public function getKeywords() : array;

    /**
     * Plugin homepage
     *
     * @return string
     */
    public function getHomepage() : string;

    /**
     * Plugin license
     *
     * @return string
     */
    public function getLicense() : string;

    /**
     * Plugin authors
     *
     * @return array
     */
    public function getAuthors() : array;

    /**
     * Plugin autoload
     *
     * @return array
     */
    public function getAutoload() : array;

    /**
     * Plugin requires
     *
     * @return array
     */
    public function getRequires() : array;

    /**
     * Plugin scripts
     *
     * @return string[]
     */
    public function getScripts() : array;

    /**
     * Plugin is abandoned
     *
     * @return bool
     */
    public function getAbandoned() : bool;

    /**
     * Plugin scripts
     *
     * @return string[]
     */
    public function getBins() : array;

    /**
     * Plugin config
     *
     * @return array
     */
    public function getConfig() : array;

    /**
     * Plugin readme file
     *
     * @return string
     */
    public function getReadme() : string;

    /**
     * Plugin suggestions
     *
     * @return array
     */
    public function getSuggests() : array;

    /**
     * Plugin support
     *
     * @return PluginSupport
     */
    public function getSupport() : PluginSupport;
}
