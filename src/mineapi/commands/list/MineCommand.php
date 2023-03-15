<?php

namespace mineapi\commands\list;

use JsonException;
use mineapi\arena\Arena;
use mineapi\MineAPI;
use mineapi\provider\Provider;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

final class MineCommand extends Command
{
    public function __construct()
    {
        parent::__construct("mine", "Manage server mines!", "/mine", [""]);
    }

    /**
     * @throws JsonException
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) return;

        if (!$sender->getServer()->isOp($sender->getName())) return;

        if (isset($args[0])){

            switch ($args[0]){

                case "create":

                    if (isset($args[1], $args[2], $args[3])){

                        $blocks = explode(",", $args[3]);
                        $blockList = [];

                        foreach ($blocks as $blockId){

                            $blockList[] = $blockId;

                        }

                        $unavailableName = [];
                        $unavailableWorld = [];

                        /**
                         * @var string $name
                         * @var Arena $value
                         */
                        foreach (Provider::$arenas as $name => $value){

                            $unavailableName[] = $name;
                            $unavailableWorld[] = $value->getWorld();

                        }

                        if (in_array($args[1], $unavailableName) or in_array($args[2], $unavailableWorld)){

                            $sender->sendMessage("A mine already has the name {$args[1]} or the world {$args[2]} is already a mine!");
                            return;

                        }

                        new Arena($args[1], $args[2], $blockList);
                        $sender->sendMessage("You have just created the {$args[1]} mine in the {$args[2]} world!");

                    } else $sender->sendMessage("You still need to specify arguments!\n/mine create (name) (world) (id1,id2)");

                    break;

                case "remove":

                    $mines = [];

                    if (isset($args[1])){

                        foreach (Provider::$arenas as $name => $value) {

                            $mines[] = $name;

                        }

                        if (in_array($args[1], $mines)){

                            MineAPI::getInstance()->getProvider()->removeArena(MineAPI::getInstance()->getProvider()->getArena($name));
                            $sender->sendMessage("You have successfully removed the {$name} mine!");

                        } else $sender->sendMessage("No mine has the name {$args[1]}!\n" . implode(", ", $mines));

                    }

                    break;

                case "list":

                    $mines = [];

                    foreach (Provider::$arenas as $name => $value) {

                        $mines[] = $name;

                    }

                    $mine = empty($mines) ? "None" : implode(", ", $mines);
                    $sender->sendMessage("Here is the list of available mines: {$mine}");
                    break;

                default:
                    $sender->sendMessage("You must write a valid argument! (create/remove/list)");
                    break;

            }

        } else $sender->sendMessage("You must specify an argument!");

    }

}