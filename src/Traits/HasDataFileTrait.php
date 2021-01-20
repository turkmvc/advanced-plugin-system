<?php


namespace IsaEken\AdvancedPluginSystem\Traits;


use IsaEken\AdvancedPluginSystem\AdvancedPluginSystem;

/**
 * Trait HasDataFileTrait
 * @package IsaEken\AdvancedPluginSystem\Traits
 */
trait HasDataFileTrait
{
    /**
     * Data file memory cache.
     *
     * @var array|null $contents
     */
    private ?array $contents = null;

    /**
     * Read the data file.
     *
     * @return array
     */
    public function readDataFile() : array
    {
        if ($this->contents === null) {
            if (!file_exists(self::$dataFile)) {
                file_put_contents(self::$dataFile, json_encode([]));
            }

            $this->contents = json_decode(file_get_contents(self::$dataFile), true);
        }

        return $this->contents;
    }

    /**
     * Write data memory cache to data file.
     *
     * @return AdvancedPluginSystem
     */
    public function writeDataFile() : AdvancedPluginSystem
    {
        if ($this->contents === null) {
            /** @var AdvancedPluginSystem $this */
            return $this;
        }

        file_put_contents(self::$dataFile, json_encode($this->contents));

        /** @var AdvancedPluginSystem $this */
        return $this;
    }

    /**
     * Check has data in data memory cache.
     *
     * @param string $key
     * @return bool
     */
    public function hasData(string $key) : bool
    {
        return isset($this->readDataFile()[$key]);
    }

    /**
     * Read data in data memory cache.
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function getData(string $key, $default = null)
    {
        if (!$this->hasData($key)) {
            return $default;
        }

        return $this->readDataFile()[$key];
    }

    /**
     * Set data in data memory cache.
     *
     * @param string $key
     * @param $value
     * @return AdvancedPluginSystem
     */
    public function setData(string $key, $value) : AdvancedPluginSystem
    {
        $this->contents[$key] = $value;

        /** @var AdvancedPluginSystem $this */
        return $this;
    }
}
