<?php

class ItemSulfuras extends AbstractItem
{
    public $qualityDropRate = 0;

    public function updateSellIn()
    {
        $this->item->sell_in = $this->item->sell_in;
    }

    public function updateQuality()
    {
        $this->item->quality = $this->item->quality;
    }
}
