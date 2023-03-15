<?php

namespace mineapi;

use JsonException;
use mineapi\loader\Loader;
use mineapi\provider\Provider;
use mineapi\provider\Provider as ProviderAlias;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

final class MineAPI extends PluginBase
{
    use SingletonTrait;

    /**
     * @return void
     */
    protected function onEnable(): void
    {
        $this->getLogger()->notice("This plugin is now available!");

        $this->saveResource("arena.json");

        (new Loader())->load();

        foreach ($this->getProvider()->getProvider()->getAll() as $name => $value){

            Provider::$arenas[$name] = unserialize($value);

        }

    }

    /**
     * @return void
     */
    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    /**
     * @return void
     * @throws JsonException
     */
    protected function onDisable(): void
    {
        $this->getLogger()->notice("This plugin is now unavailable!");

        $this->getProvider()->saveArena();
    }

    /**
     * @return ProviderAlias
     */
    public function getProvider() : ProviderAlias
    {
        return new ProviderAlias();
    }

}