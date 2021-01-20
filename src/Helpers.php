<?php


namespace IsaEken\AdvancedPluginSystem;


use Illuminate\Support\Str;
use InvalidArgumentException;
use IsaEken\AdvancedPluginSystem\Enums\Patterns;
use Spatie\Regex\Regex;

/**
 * Class Helpers
 * @package IsaEken\AdvancedPluginSystem
 */
class Helpers
{
    /**
     * Check is valid plugin name.
     *
     * @param string $name
     * @return bool
     */
    public static function isName(string $name) : bool
    {
        // test $name variable using name pattern.
        return Regex::match(Patterns::Name, $name)->hasMatch();
    }

    /**
     * Check is valid plugin version.
     *
     * @param string $version
     * @return bool
     */
    public static function isVersion(string $version) : bool
    {
        // test $version variable using version pattern.
        return Regex::match(Patterns::Version, $version)->hasMatch();
    }

    /**
     * Check is valid package.
     *
     * @param string $name
     * @param string $version
     * @return bool
     */
    public static function isPackage(string $name, string $version) : bool
    {
        // check $name and $version variables is valid.
        return self::isName($name) && self::isVersion($version);
    }

    /**
     * Convert version string to object.
     *
     * @param string $version
     * @return object
     */
    public static function version(string $version) : object
    {
        // create regex match class using $version variable and version pattern.
        $ver = Regex::match(Patterns::Version, $version);

        // get groups if regex is matched else returns blank array.
        $groups = $ver->hasMatch() ? $ver->groups() : [];

        // return the object.
        return (object) [
            "version"       => $version,
            "isValid"       => $ver->hasMatch(),
            "major"         => isset($groups["major"]) ? $groups["major"] : null,
            "minor"         => isset($groups["minor"]) ? $groups["minor"] : null,
            "patch"         => isset($groups["patch"]) ? $groups["patch"] : null,
            "prerelease"    => isset($groups["prerelease"]) ? $groups["prerelease"] : null,
            "buildmetadata" => isset($groups["buildmetadata"]) ? $groups["buildmetadata"] : null,
        ];
    }

    /**
     * Get boolean value from value.
     *
     * @param mixed $variable
     * @return bool
     */
    public static function booleanFromVar($variable) : bool
    {
        if (is_string($variable)) {
            return in_array(Str::of($variable)->lower()->trim()->replace([" ", "\t", "\t"], "")->__toString(), ["true", "yes", "ok"]);
        }
        else if (is_numeric($variable)) {
            return $variable > 0;
        }
        else if (is_bool($variable)) {
            return (bool) boolval($variable);
        }
        else {
            throw new InvalidArgumentException("Invalid boolean variable.");
        }
    }
}
