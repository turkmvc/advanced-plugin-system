<?php


namespace IsaEken\AdvancedPluginSystem\Interfaces;


/**
 * Interface PluginAuthorInterface
 * @package IsaEken\AdvancedPluginSystem\Interfaces
 */
interface PluginAuthorInterface
{
    /**
     * Get the full name of plugin author.
     *
     * @return string
     */
    public function getName() : string;

    /**
     * Get the email address of plugin author.
     *
     * @return string
     */
    public function getEmail() : string;

    /**
     * Get the homepage address of plugin author.
     *
     * @return string
     */
    public function getHomepage() : string;

    /**
     * Get the role.
     *
     * @return string
     */
    public function getRole() : string;
}
