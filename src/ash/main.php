<?php

namespace ash;


use ash\Commands\tpall;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class main extends PluginBase implements Listener{

    /**@var $db Config*/
    public $db;

    private static $instance;

    public function onLoad()
    {
        $this->saveResource("config.yml");
    }

    public function onEnable()
    {
        self::$instance = $this;
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");

        $this->getServer()->getCommandMap()->registerAll('Commands',[
            new tpall("tpall","teleporter tous les joueurs à soi","/tpall")
        ]);


        $this->db = new Config($this->getDataFolder() . "config.yml" . Config::YAML);
    }
    public static function tpall()
    {
        return new Config(main::getInstance()->getDataFolder()."config.yml",Config::YAML);
    }

    public static function getInstance()
    {
        return self::$instance;
    }
}