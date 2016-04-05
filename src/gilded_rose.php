<?php

class GildedRose {

    private $items;

    function __construct($items) {
        $this->items = $items;
    }

    function update_quality() {
        foreach ($this->items as $item) {
            $this->updateItemSellIn($item);
            $this->updateItemQuality($item);
        }
    }

    /**
     * Update sell_in property
     *
     * @param Item $item
     */
    public function updateItemSellIn(Item $item)
    {
        if ($item->name != 'Sulfuras, Hand of Ragnaros') {
            $item->sell_in = $item->sell_in - 1;
        }
    }

    /**
     * Update sell_in property
     *
     * @param Item $item
     */
    public function updateItemQuality(Item &$item)
    {
        $dropRate = $this->getItemDropRate($item);

        $item->quality = $item->quality + $dropRate;

        $this->validateItemQuality($item);
    }

    /**
     * Get item drop rate
     *
     * @param Item $item
     */
    public function getItemDropRate(Item $item)
    {
        switch ($item->name) {
            case 'Aged Brie':
                $dropRate = 1;
                if ($item->sell_in < 0) {
                    $dropRate = $dropRate * 2;
                }
                break;

            case 'Backstage passes to a TAFKAL80ETC concert':
                $dropRate = 1;
                if ($item->sell_in < 10) {
                    $dropRate = 2;
                }
                if ($item->sell_in < 5) {
                    $dropRate = 3;
                }
                if ($item->sell_in < 0) {
                    $dropRate = -$item->quality;
                }
                break;

            case 'Sulfuras, Hand of Ragnaros':
                $dropRate = 0;
                break;

            default:
                $dropRate = -1;
                if ($item->sell_in < 0) {
                    $dropRate = $dropRate * 2;
                }
                break;
        }

        return $dropRate;
    }

    public function validateItemQuality(Item &$item)
    {
        switch ($item->name) {
            case 'Sulfuras, Hand of Ragnaros':
                $item->quality = $item->quality;
                break;

            default:
                if ($item->quality >= 50) {
                    $item->quality = 50;
                }
                else if ($item->quality < 0) {
                    $item->quality = 0;
                }
                break;
        }
    }

    /**
     * Update item quality before sell_in update
     *
     * @param Item $item
     */
    public function updateQualityBeforeSellIn(Item $item)
    {
        if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
            if ($item->quality > 0) {
                if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                    $item->quality = $item->quality - 1;
                }
            }
        } else {
            if ($item->quality < 50) {
                $item->quality = $item->quality + 1;
                if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                    if ($item->sell_in < 11) {
                        if ($item->quality < 50) {
                            $item->quality = $item->quality + 1;
                        }
                    }
                    if ($item->sell_in < 6) {
                        if ($item->quality < 50) {
                            $item->quality = $item->quality + 1;
                        }
                    }
                }
            }
        }
    }

    /**
     * Update item quality after update sell_in
     *
     * @param Item $item
     */
    public function updateQualityAfterSellIn($item)
    {
        if ($item->sell_in < 0) {
            if ($item->name != 'Aged Brie') {
                if ($item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                    if ($item->quality > 0) {
                        if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                            $item->quality = $item->quality - 1;
                        }
                    }
                } else {
                    $item->quality = $item->quality - $item->quality;
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;
                }
            }
        }
    }
}

class Item {

    public $name;
    public $sell_in;
    public $quality;

    function __construct($name, $sell_in, $quality) {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }

    public function __toString() {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }

}
