<?php

namespace mineapi\listeners\list;

use mineapi\MineAPI;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\scheduler\ClosureTask;

class MineListener implements Listener
{
    /**
     * @param BlockBreakEvent $event
     * @return void
     */
    public function onBlockBreakEvent(BlockBreakEvent $event) : void
    {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $world = $player->getWorld();

        if (!is_null(MineAPI::getInstance()->getProvider()->getArenaByWorld($world))){

            $arena = MineAPI::getInstance()->getProvider()->getArena(MineAPI::getInstance()->getProvider()->getArenaByWorld($world));

            if (in_array($block->getId(), $arena->getBlocks())){

                $event->cancel();

                $block->getPosition()->getWorld()->setBlock($block->getPosition(), VanillaBlocks::BEDROCK());

                MineAPI::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($block) {

                    $block->getPosition()->getWorld()->setBlock($block->getPosition(), $block);

                }), 20 * 5);

            }

        }

    }

}
