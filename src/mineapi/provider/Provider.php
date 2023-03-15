<?php

namespace mineapi\provider;

use JsonException;
use mineapi\arena\Arena;
use mineapi\MineAPI;
use pocketmine\utils\Config;
use pocketmine\world\World;

class Provider
{
    /*** @var array */
    public static array $arenas = [];

    /**
     * @param Arena $arena
     * @return void
     */
    public static function addArena(Arena $arena) : void
    {
        self::$arenas[$arena->getName()] = $arena;
    }

    /**
     * @param Arena $arena
     * @return void
     * @throws JsonException
     */
    public function removeArena(Arena $arena): void
    {
        $provider = $this->getProvider();

        if (isset(self::$arenas[$arena->getName()])){

            unset(self::$arenas[$arena->getName()]);

        }

        $provider->remove($arena->getName());
        $provider->save();

    }

    /**
     * @throws JsonException
     */
    public function saveArena() : void
    {
        $provider = $this->getProvider();

        /**
         * @var string $name
         * @var Arena $arena
         */
        foreach (self::$arenas as $name => $arena){

            $provider->set($name, $arena->serialize());
            $provider->save();

        }

    }

    /**
     * @param string $arenaName
     * @return Arena|null
     */
    public function getArena(string $arenaName) : ?Arena
    {
        /**
         * @var string $name
         * @var Arena $value
         */
        foreach (self::$arenas as $name => $value){

            if (strtolower($arenaName) === strtolower($name)){

                return $value;

            }

        }

        return null;

    }

    /**
     * @param World $world
     * @return string|null
     */
    public function getArenaByWorld(World $world) : ?string
    {
        $arenaName = null;

        /**
         * @var string $name
         * @var Arena $value
         */
        foreach (self::$arenas as $name => $value){

            if ($world->getFolderName() === $value->getWorld()){

                $arenaName = $name;

            }

        }

        return $arenaName;

    }

    /**
     * @return Config
     */
    public function getProvider() : Config
    {
        return new Config(MineAPI::getInstance()->getDataFolder() . "arena.json", Config::JSON);
    }

}
