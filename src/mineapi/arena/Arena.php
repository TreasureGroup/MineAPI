<?php

namespace mineapi\arena;

use mineapi\MineAPI;
use pocketmine\world\World;

final class Arena
{
    /*** @var string */
    private string $name;
    /*** @var World */
    private string $world;
    /*** @var array */
    private array $blocks;

    /**
     * @param string $name
     * @param string $world
     * @param array $blocks
     */
    public function __construct(string $name, string $world, array $blocks)
    {
        $this->name = $name;
        $this->world = $world;
        $this->blocks = $blocks;

        MineAPI::getInstance()->getProvider()->addArena($this);
    }

    /**
     * @return string
     */
    public function serialize() : string
    {
        return serialize($this);
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getWorld() : string
    {
        return $this->world;
    }

    /**
     * @return array
     */
    public function getBlocks() : array
    {
        return $this->blocks;
    }

}