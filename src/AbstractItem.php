<?php

abstract class AbstractItem implements InterfaceItem
{
    const MAX_QUALITY = 50;
    const MIN_QUALITY = 0;

    public $qualityDropRate = -1;
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
        if ($this->isExpired()) {
            return 2 * $this->qualityDropRate;
        }

        return $this->qualityDropRate;
    }

    public function isExpired()
    {
        return $this->item->sell_in < 0;
    }
}
