<?php

abstract class AbstractItem implements InterfaceItem
{
    const MAX_QUALITY = 50;
    const MIN_QUALITY = 0;
    const QUALITY_DROP_RATE = -1;

    public $sell_in;
    public $quality;

    function __construct(Item $item)
    {
        $this->sell_in = $item->sell_in;
        $this->quality = $item->quality;
    }

    public function updateProperties()
    {
        $this->updateSellIn();
        $this->updateQuality();
    }

    public function updateSellIn()
    {
        $this->sell_in = $this->sell_in - 1;
    }

    public function updateQuality()
    {
        $dropRate = $this->getQualityDropRate();
        $this->quality = $this->quality + $dropRate;

        if ($this->quality > self::MAX_QUALITY) {
            $this->quality = self::MAX_QUALITY;
        }

        if ($this->quality < self::MIN_QUALITY) {
            $this->quality = self::MIN_QUALITY;
        }
    }

    public function getQualityDropRate()
    {
        if ($this->sell_in < 0) {
            return 2 * self::QUALITY_DROP_RATE;
        }

        return self::QUALITY_DROP_RATE;
    }
}
