<?php

namespace mineapi\loader;

use mineapi\commands\CommandManager;
use mineapi\listeners\ListenerManager;
use mineapi\MineAPI;

class Loader
{
    /**
     * @return void
     */
    public function load() : void
    {
        $managers = [new CommandManager(), new ListenerManager()];

        foreach ($managers as $loader){

            if (!$loader instanceof LoaderManager) continue;

            $loader->onInit();

            MineAPI::getInstance()->getLogger()->info("{$loader->getName()} load with success!");

        }

    }

}
