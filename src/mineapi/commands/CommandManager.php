<?php

namespace mineapi\commands;

use mineapi\commands\list\MineCommand;
use mineapi\loader\LoaderManager;
use pocketmine\Server;

class CommandManager implements LoaderManager
{
    /**
     * @return void
     */
    public function onInit(): void
    {
        $commands = [new MineCommand()];

        foreach ($commands as $command){

            Server::getInstance()->getCommandMap()->register("", $command);

        }

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "Command";
    }

}

