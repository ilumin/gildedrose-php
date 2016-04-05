<?php

require_once 'InterfaceItem.php';
require_once 'AbstractItem.php';
require_once 'ItemAgedBrie.php';
require_once 'ItemBackstage.php';
require_once 'ItemSulfuras.php';
require_once 'ItemConjured.php';
require_once 'ItemDefault.php';

define('AGEDBRIE', 'Aged Brie');
define('BACKSTAGE', 'Backstage passes to a TAFKAL80ETC concert');
define('SULFURAS', 'Sulfuras, Hand of Ragnaros');
define('CONJURED', 'Conjured Mana Cake');

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
                case AGEDBRIE:
                    $gildedRoseItem = new ItemAgedBrie($item);
                    break;

                case BACKSTAGE:
                    $gildedRoseItem = new ItemBackstage($item);
                    break;

                case SULFURAS:
                    $gildedRoseItem = new ItemSulfuras($item);
                    break;

                case CONJURED:
                    $gildedRoseItem = new ItemConjured($item);
                    break;

                default:
                    $gildedRoseItem = new ItemDefault($item);
                    break;
            }

            $this->items[] = $gildedRoseItem;
        }
    }
}
