<?php

require_once 'GildedRose.php';
require_once 'Item.php';

echo "OMGHAI!\n";

$items = array(
    new Item('+5 Dexterity Vest', 10, 20),
    new Item('+5 Dexterity Vest', 0, 20),
    new Item('Aged Brie', 2, 0),
    new Item('Aged Brie', 6, 47),
    new Item('Elixir of the Mongoose', 5, 7),
    new Item('Sulfuras, Hand of Ragnaros', 0, 80),
    new Item('Sulfuras, Hand of Ragnaros', -1, 80),
    new Item('Backstage passes to a TAFKAL80ETC concert', 15, 49),
    new Item('Backstage passes to a TAFKAL80ETC concert', 10, 20),
    new Item('Backstage passes to a TAFKAL80ETC concert', 2, 10),
    // this conjured item does not work properly yet
    new Item('Conjured Mana Cake', 1, 20)
);

$app = new GildedRose($items);

$days = 6;
if (count($argv) > 1) {
    $days = (int) $argv[1];
}

for ($i = 0; $i < $days; $i++) {
    echo("-------- day $i --------\n");
    echo("name, sellIn, quality\n");
    foreach ($items as $item) {
        echo $item . PHP_EOL;
    }
    echo PHP_EOL;
    $app->update_quality();
}
