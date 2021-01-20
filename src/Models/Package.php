<?php


namespace IsaEken\AdvancedPluginSystem\Models;


/**
 * Class Package
 * @package IsaEken\AdvancedPluginSystem\Models
 */
class Package
{
    /**
     * @var string $name
     */
    public string $name;

    /**
     * @var string|null $version
     */
    public ?string $version = null;

    /**
     * Package constructor.
     *
     * @param string $name
     * @param string|null $version
     */
    public function __construct(string $name, string $version = null)
    {
        $this->name = $name;
        $this->version = $version;
    }

    public function exists() : bool
    {


        $platformRepo = new \Composer\Repository\PlatformRepository;
        $composer = \Composer\Factory::create(new \Composer\IO\NullIO(), array(), false);

        $localRepo = $composer->getRepositoryManager()->getLocalRepository();
        $installedRepo = new \Composer\Repository\CompositeRepository(array($localRepo, $platformRepo));
        $repos = new \Composer\Repository\CompositeRepository(array_merge(array($installedRepo), $composer->getRepositoryManager()->getRepositories()));

        dd($repos->getProviders("isaeken/plugin-system"));
//        dd($repos->search("isaeken/plugin-system"), \Composer\Repository\RepositoryInterface::SEARCH_NAME));

//        $repo = new \Composer\Package\Link();
        dd($repos->findPackage("isaeken/plugin-system", $package));
        dd($package);

//        dd(\Composer\InstalledVersions::($this->name));

        $package = new \Composer\Config();
        dd($package);
    }
}
