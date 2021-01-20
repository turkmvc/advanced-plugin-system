<?php


namespace IsaEken\AdvancedPluginSystem\Interfaces;


/**
 * Interface PluginSupportInterface
 * @package IsaEken\AdvancedPluginSystem\Interfaces
 */
interface PluginSupportInterface
{
    /**
     * Plugin support email address
     *
     * @return string
     */
    public function getEmail() : string;

    /**
     * Plugin support docs address
     *
     * @return string
     */
    public function getDocs() : string;

    /**
     * Plugin support forum address
     *
     * @return string
     */
    public function getForum() : string;

    /**
     * Plugin support irc address
     *
     * @return string
     */
    public function getIrc() : string;

    /**
     * Plugin support issues address
     *
     * @return string
     */
    public function getIssues() : string;

    /**
     * Plugin support rss address
     *
     * @return string
     */
    public function getRss() : string;

    /**
     * Plugin support source address
     *
     * @return string
     */
    public function getSource() : string;

    /**
     * Plugin support wiki address
     *
     * @return string
     */
    public function getWiki() : string;
}
