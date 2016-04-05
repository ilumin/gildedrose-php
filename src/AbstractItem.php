<?php

abstract class AbstractItem implements InterfaceItem
{
    public $qualityDropRate = -1;
    public $maxQuality = 50;
    public $minQuality = 0;

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

        if ($this->item->quality > $this->maxQuality) {
            $this->item->quality = $this->maxQuality;
        }

        if ($this->item->quality < $this->minQuality) {
            $this->item->quality = $this->minQuality;
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
