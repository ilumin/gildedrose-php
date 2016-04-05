<?php

class ItemSulfuras extends AbstractItem
{
    const QUALITY_DROP_RATE = 0;

    public function updateSellIn()
    {
        $this->item->sell_in = $this->item->sell_in;
    }

    public function updateQuality()
    {
        $this->item->quality = $this->item->quality;
    }
}
