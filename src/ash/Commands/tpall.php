<?php

namespace ash\Commands;

use ash\main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Player;
use pocketmine\Server;

class tpall extends Command{

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            if($sender->hasPermission("use.tpall")){
                $sendername = $sender->getName();
                $db = main::tpall();
                $prefix = $db->get("TeleportMessagePrefix");
                $time = $db->get("Timetotp");

                if($time->is_numeric()){
                    foreach( Server::getInstance()->getOnlinePlayers() as $p){
                        $p->setImmobile(true);
                        $p->sendPopup($db->get("Timetotp"). "secondes", $db->get("MessageBeforeTeleportation"));
                        $p->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS), 1209, 3, false));
                        sleep($db->get("TeleportTime"));
                        $p->teleport($sender);
                        $p->setImmobile(false);
                        $p->removeEffect(15);
                        $p->sendMessage($prefix."teleportation à ".$sendername);
                    }
                }else{
                    if($time = "none"){
                        foreach( Server::getInstance()->getOnlinePlayers() as $p){
                            $p->teleport($sender);
                            $p->sendMessage($prefix."téléportation à ".$sendername);
                        }
                    }else{
                        $sender->sendMessage("Veuillez rentrer une configuration correcte avant utilisation");
                    }
                }

            }else{
                $sender->sendMessage("§4/!\ §fTu n'as pas la permission d'utiliser cette commande");
            }
        }else{
            $sender->sendMessage("Commande à utiliser en jeu");
        }
    }
}