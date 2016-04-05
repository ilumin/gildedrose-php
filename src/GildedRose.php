<?php

require_once 'InterfaceItem.php';
require_once 'AbstractItem.php';
require_once 'ItemAgedBrie.php';
require_once 'ItemBackstage.php';
require_once 'ItemSulfuras.php';
require_once 'ItemDefault.php';

class GildedRose {

    private $items;

    function __construct($items) {
        $this->registerGildedRoseItem($items);
    }

    function update_quality() {
        foreach ($this->items as $item) {
            $item->updateProperties();
        }
    }

    public function registerGildedRoseItem(array $items)
    {
        foreach ($items as $item) {
            switch ($item->name) {
                case 'Aged Brie':
                    $gildedRoseItem = new ItemAgedBrie($item);
                    break;

                case 'Backstage passes to a TAFKAL80ETC concert':
                    $gildedRoseItem = new ItemBackstage($item);
                    break;

                case 'Sulfuras, Hand of Ragnaros':
                    $gildedRoseItem = new ItemSulfuras($item);
                    break;

                default:
                    $gildedRoseItem = new ItemDefault($item);
                    break;
            }

            $this->items[] = $gildedRoseItem;
        }
    }
}
