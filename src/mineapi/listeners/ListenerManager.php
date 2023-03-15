<?php

namespace mineapi\listeners;

use mineapi\listeners\list\MineListener;
use mineapi\loader\LoaderManager;
use mineapi\MineAPI;
use pocketmine\Server;

class ListenerManager implements LoaderManager
{
    /**
     * @return void
     */
    public function onInit(): void
    {
        Server::getInstance()->getPluginManager()->registerEvents(new MineListener(), MineAPI::getInstance());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "Listener";
    }

}
