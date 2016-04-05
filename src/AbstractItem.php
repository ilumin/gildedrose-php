<?php

abstract class AbstractItem implements InterfaceItem
{
    const MAX_QUALITY = 50;
    const MIN_QUALITY = 0;
    const QUALITY_DROP_RATE = -1;

    public $item;

    function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function updateProperties()
    {
        $this->updateSellIn();
        $this->updateQuality();
    }

    public function updateSellIn()
    {
        $this->item->sell_in = $this->item->sell_in - 1;
    }

    public function updateQuality()
    {
        $dropRate = $this->getQualityDropRate();
        $this->item->quality = $this->item->quality + $dropRate;

        if ($this->item->quality > self::MAX_QUALITY) {
            $this->item->quality = self::MAX_QUALITY;
        }

        if ($this->item->quality < self::MIN_QUALITY) {
            $this->item->quality = self::MIN_QUALITY;
        }
    }

    public function getQualityDropRate()
    {
        if ($this->item->sell_in < 0) {
            return 2 * self::QUALITY_DROP_RATE;
        }

        return self::QUALITY_DROP_RATE;
    }
}
