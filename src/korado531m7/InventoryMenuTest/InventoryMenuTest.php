<?php
namespace korado531m7\InventoryMenuTest;

use korado531m7\InventoryMenuAPI\InventoryMenuAPI as IM;
use korado531m7\InventoryMenuAPI\event\InventoryMenuClickEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;

class InventoryMenuTest extends PluginBase implements Listener{
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    public function onJoin(PlayerInteractEvent $event){
        $p = $event->getPlayer();
        if($p->isOp()){
            $item = [13 => Item::get(116)->setCustomName('§6INVENTORY MENU TESTING')->setLore(['','§aYou can use inventory menu api like this','§6It\'s awesome']), 38 => Item::get(276)->setCustomName('§6Calculation Test'), 42 => Item::get(331)->setCustomName('§aWhich do you like?')];
            IM::sendInventoryMenu($p, $item, '§bExample InventoryMenu', IM::INVENTORY_TYPE_DOUBLE_CHEST);
        }
    }
    
    public function onClicked(InventoryMenuClickEvent $event){
        $p = $event->getPlayer();
        $name = $event->getMenuName();
        $item = $event->getItem();
        switch($name){
            case '§bExample InventoryMenu':
                if($item->getId() === 276){
                    $items = [0 => Item::get(332)->setCustomName('§l§b3'), 4 => Item::get(332)->setCustomName('§l§b6')];
                    IM::fillInventoryMenu($p, $items, '§6What is 1 + 5?', IM::INVENTORY_TYPE_HOPPER);
                }else{
                    $items = [Item::get(260),Item::get(282),Item::get(297),Item::get(320),Item::get(349),Item::get(354),Item::get(357),Item::get(360),Item::get(364)];
                    IM::fillInventoryMenu($p, $items, '§aWhich do you like?', IM::INVENTORY_TYPE_DISPENSER);
                }
            break;
            
            case '§aWhich do you like?':
                $p->sendMessage('§aWow you like '.$item->getName().' !');
            break;
            
            case '§6What is 1 + 5?':
                if($item->getCustomName() === '§l§b3'){
                    $p->sendMessage('§cOh, that\'s incorrect :(');
                }elseif($item->getCustomName() === '§l§b6'){
                    $p->sendMessage('§aYeah! It\'s correct!');
                }
            break;
        }
    }
}