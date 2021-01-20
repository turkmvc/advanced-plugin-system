<?php


namespace IsaEken\AdvancedPluginSystem;


use Illuminate\Support\Collection;
use IsaEken\AdvancedPluginSystem\Autoloaders\JsonAutoloader;
use IsaEken\AdvancedPluginSystem\Exceptions\DirectoryNotFoundException;
use IsaEken\AdvancedPluginSystem\Interfaces\AutoloaderInterface;

/**
 * Class PluginFinder
 *
 * @package IsaEken\AdvancedPluginSystem
 * @property bool $nested
 * @property array $ignores
 */
class PluginFinder
{
    /**
     * @var Collection $plugins
     */
    public Collection $plugins;

    /**
     * @var AdvancedPluginSystem|null $advancedPluginSystem
     */
    public ?AdvancedPluginSystem $advancedPluginSystem = null;

    /**
     * @var array $autoloaders
     */
    public static array $autoloaders = [];

    /**
     * @var string $path
     */
    private string $path;

    /**
     * @var array $options
     */
    private array $options = [];

    /**
     * PluginFinder constructor.
     *
     * @param string $path
     * @param array $options
     */
    public function __construct(string $path, array $options = [])
    {
        $this->plugins = collect();
        $this->path = $path;
        $this->options = array_merge($options, [
            'ignores' => [
                '.', '..',
            ],
            'autoloaders' => [
                JsonAutoloader::class,
            ],
        ]);
        self::$autoloaders = $this->options['autoloaders'];
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (isset($this->options[$name])) {
            $this->options[$name] = $value;
            return;
        }

        $this->$name = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }

        return $this->$name;
    }

    /**
     * @return PluginFinder
     * @throws DirectoryNotFoundException
     */
    public function find() : PluginFinder
    {
        $nested = isset($this->options['nested']) ? $this->options['nested'] : true;

        if (!is_dir($this->path)) {
            throw new DirectoryNotFoundException($this->path);
        }

        $this->findInDirectory($this->path, $nested);

        return $this;
    }

    /**
     * @param $_path
     * @param $nested
     */
    private function findInDirectory($_path, $nested)
    {
        if (is_dir($_path)) {
            foreach (scandir($_path) as $path) {
                if (in_array($path, $this->ignores)) {
                    continue;
                }

                $path = realpath(implode(DIRECTORY_SEPARATOR, [$_path, $path]));
                $autoloader = self::findAutoloader($path);

                if ($autoloader !== null) {
                    $autoloader = new $autoloader($path);
                    $autoloader->advancedPluginSystem = $this->advancedPluginSystem;
                    $autoloader->getPlugin()->advancedPluginSystem = $this->advancedPluginSystem;
                    $autoloader->getPlugin()->path = $path;
                    $this->plugins->put($autoloader->getPlugin()->getName(), $autoloader->getPlugin());
                    continue;
                }

                if ($nested) {
                    $this->findInDirectory($path, $nested);
                }
            }
        }
        else if (is_file($_path)) {
            $path = $_path;
            $autoloader = self::findAutoloader($path);
            if ($autoloader !== null) {
                $autoloader = new $autoloader($path);
                $autoloader->advancedPluginSystem = $this->advancedPluginSystem;
                $autoloader->getPlugin()->advancedPluginSystem = $this->advancedPluginSystem;
                $autoloader->getPlugin()->path = $path;
                $this->plugins->put($autoloader->getPlugin()->getName(), $autoloader->getPlugin());
            }
        }
    }

    /**
     * @param string $path
     * @return AutoloaderInterface|null
     */
    public static function findAutoloader(string $path) : ?AutoloaderInterface
    {
        $autoloader = null;

        foreach (self::$autoloaders as $_autoloader) {
            if ($_autoloader::isValid($path)) {
                $autoloader = new $_autoloader($path);
                break;
            }
        }

        return $autoloader;
    }
}
