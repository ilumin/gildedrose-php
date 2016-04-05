<?php

class ItemSulfuras extends AbstractItem
{
    const QUALITY_DROP_RATE = 0;

    public function updateSellIn()
    {
        $this->sell_in = $this->sell_in;
    }

    public function updateQuality()
    {
        $this->quality = $this->quality;
    }
}
