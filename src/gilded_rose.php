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
    public function updateItemQuality(Item $item)
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

    /**
     * Validate and update item quality
     *
     * @param Item $item
     */
    public function validateItemQuality(Item $item)
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
}
