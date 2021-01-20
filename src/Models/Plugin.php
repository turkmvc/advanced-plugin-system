<?php


namespace IsaEken\AdvancedPluginSystem\Models;


use Illuminate\Support\Str;
use IsaEken\AdvancedPluginSystem\AdvancedPluginSystem;
use IsaEken\AdvancedPluginSystem\Enums\PluginType;
use IsaEken\AdvancedPluginSystem\Exceptions\InvalidVersionException;
use IsaEken\AdvancedPluginSystem\Helpers;
use IsaEken\AdvancedPluginSystem\Interfaces\HasExecutablesInterface;
use IsaEken\AdvancedPluginSystem\Interfaces\HasHooksInterface;
use IsaEken\AdvancedPluginSystem\Interfaces\HasVariablesInterface;
use IsaEken\AdvancedPluginSystem\Interfaces\PluginInterface;
use IsaEken\AdvancedPluginSystem\Interfaces\PluginStateInterface;
use IsaEken\AdvancedPluginSystem\Traits\HasExecutablesTrait;
use IsaEken\AdvancedPluginSystem\Traits\HasHooksTrait;
use IsaEken\AdvancedPluginSystem\Traits\HasPluginStatesTrait;
use IsaEken\AdvancedPluginSystem\Traits\HasVariablesTrait;
use IsaEken\AdvancedPluginSystem\Traits\PluginAutoloadTrait;

/**
 * Class Plugin
 * @package IsaEken\AdvancedPluginSystem\Models
 * @property string $name
 * @property string $version
 * @property string $description
 * @property array $keywords
 * @property string $homepage
 * @property string $license
 * @property string $readme
 * @property array $authors
 * @property array $require
 * @property bool $abandoned
 * @property array $bin
 * @property array $config
 * @property array $suggest
 * @property PluginSupport $support
 */
class Plugin implements PluginInterface, PluginStateInterface, HasExecutablesInterface, HasVariablesInterface, HasHooksInterface
{
    use PluginAutoloadTrait;
    use HasPluginStatesTrait;
    use HasExecutablesTrait;
    use HasVariablesTrait;
    use HasHooksTrait;

    public ?AdvancedPluginSystem $advancedPluginSystem = null;

    public string $path;

    public string $pluginType = PluginType::Basic;

    private array $configuration = [];

    private array $defaults = [
        "version" => "1.0.0",
        "description" => "",
        "keywords" => [],
        "homepage" => "",
        "license" => "MIT",
        "readme" => "",
        "authors" => [],
        "autoload" => [],
        "require" => [],
        "abandoned" => false,
        "bin" => [],
        "config" => [
            "bin-dir" => "bin/",
            "htaccess-protect" => true,
            "supported-platforms" => "*",
            "process-timeout" => 60,
            "use-composer-installer" => false,
        ],
        "suggest" => [],
        "support" => [
            "wiki" => null,
            "source" => null,
            "rss" => null,
            "issues" => null,
            "irc" => null,
            "forum" => null,
            "docs" => null,
            "email" => null,
        ]
    ];

    /**
     * Plugin constructor.
     *
     * @param array $configuration
     * @throws InvalidVersionException
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;

        if (isset($this->configuration["authors"])) {
            $authors = collect();
            foreach ($this->configuration["authors"] as $author) {
                $authors->add(new PluginAuthor($author));
            }
            $this->configuration["authors"] = $authors;
        }

        if (isset($this->configuration["version"])) {
            if (!Helpers::isVersion($this->configuration["version"])) {
                throw new InvalidVersionException("The plugin \"" . $this->configuration["name"] . "\" version \"" . $this->configuration["version"] . "\" is invalid. See semantic versioning.");
            }
        }

        $this->configuration["support"] = new PluginSupport(isset($this->configuration["support"]) ? $this->configuration["support"] : []);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->configuration[$name])) {
            return $this->configuration[$name];
        }

        if (isset($this->defaults[$name])) {
            return $this->defaults[$name];
        }

        return $this->$name;
    }

    /**
     * Plugin name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Plugin version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Plugin id
     *
     * @return string
     */
    public function getId(): string
    {
        if (!isset($this->configuration['id']) || $this->configuration['id'] == null || strlen($this->configuration['id']) < 1) {
            $this->configuration['id'] = AdvancedPluginSystem::createPluginId($this->getName(), $this->getVersion());
        }

        return $this->configuration['id'];
    }

    /**
     * Plugin description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Plugin keywords
     *
     * @return string[]
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }

    /**
     * Plugin homepage
     *
     * @return string
     */
    public function getHomepage(): string
    {
        return $this->homepage;
    }

    /**
     * Plugin license
     *
     * @return string
     */
    public function getLicense(): string
    {
        return $this->license;
    }

    /**
     * Plugin authors
     *
     * @return array
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * Plugin autoload
     *
     * @return array
     */
    public function getAutoload() : array
    {
        return $this->autoload;
    }

    /**
     * Plugin requires
     *
     * @return array
     */
    public function getRequires(): array
    {
        return $this->requires;
    }

    /**
     * Plugin scripts
     *
     * @return string[]
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }

    /**
     * Plugin is abandoned
     *
     * @return bool
     */
    public function getAbandoned(): bool
    {
        return $this->abandoned;
    }

    /**
     * Plugin scripts
     *
     * @return string[]
     */
    public function getBins(): array
    {
        return $this->bins;
    }

    /**
     * Plugin config
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Plugin readme file
     *
     * @return string
     */
    public function getReadme(): string
    {
        return $this->readme;
    }

    /**
     * Plugin suggestions
     *
     * @return array
     */
    public function getSuggests(): array
    {
        return $this->suggests;
    }

    /**
     * Plugin support
     *
     * @return PluginSupport
     */
    public function getSupport(): PluginSupport
    {
        return $this->support;
    }
}
