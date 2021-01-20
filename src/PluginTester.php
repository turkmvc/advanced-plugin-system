<?php


namespace IsaEken\AdvancedPluginSystem;


use Illuminate\Support\Str;
use IsaEken\AdvancedPluginSystem\Enums\PluginType;

class PluginTester
{
    /**
     * @var string $path
     */
    public string $path;

    /**
     * @var string $pluginType
     */
    public string $pluginType;

    /**
     * PluginTester constructor.
     *
     * @param string $path
     * @param string $pluginType
     */
    public function __construct(string $path, string $pluginType = PluginType::Basic)
    {
        $this->path = $path;
        $this->pluginType = $pluginType;
    }

    /**
     * Check plugin is a basic plugin
     *
     * @return bool
     */
    public function isBasicPlugin() : bool
    {
        if (!file_exists($this->path) || !is_file($this->path)) {
            return false;
        }

        $classname = self::getFileClass($this->path);

        if (strlen($classname) < 1) {
            return false;
        }

        if (Str::of($classname)->afterLast('\\') != Str::of($this->path)->basename()->beforeLast('.')) {
            return false;
        }

        return true;
    }

    /**
     * Check plugin is valid plugin.
     *
     * @return bool
     */
    public function isValid() : bool
    {
        if ($this->pluginType == PluginType::Basic) {
            return $this->isBasicPlugin();
        }
        else if ($this->pluginType == PluginType::Autoloader) {
            return false;
        }
        return false;
    }

    /**
     * Get class with namespace from file without using include or require.
     *
     * @param string $filename
     * @return string
     */
    public static function getFileClass(string $filename) : string
    {
        $file = fopen($filename, "r");
        $namespace = "";
        $class = $buffer = "";
        $i = 0;

        while (!$class) {

            if (feof($file)) {
                break;
            }

            $buffer .= fread($file, 512);
            $tokens = token_get_all($buffer);

            if (strpos($buffer, '{') === false) {
                continue;
            }

            for (; $i < count($tokens); $i++) {
                if ($tokens[$i][0] === T_CLASS) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j] === '{') {
                            $class = $tokens[$i + 2][1];
                        }
                    }
                }
                else if ($tokens[$i][0] === T_NAMESPACE) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j] === '{') {
                            $namespace = $tokens[$i + 2][1];
                        }
                    }
                }
            }
        }

        return strlen($namespace) > 0 ? $namespace."\\".$class : $class;
    }
}
