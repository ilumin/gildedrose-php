<?php

class ItemBackStage extends AbstractItem
{
    const QUALITY_DROP_RATE = 1;

    public function getQualityDropRate()
    {
        if ($this->item->sell_in < 0) {
            return 0 * self::QUALITY_DROP_RATE;
        }

        if ($this->item->sell_in < 5) {
            return 3 * self::QUALITY_DROP_RATE;
        }

        if ($this->item->sell_in < 10) {
            return 3 * self::QUALITY_DROP_RATE;
        }

        return parent::getQualityDropRate();
    }
}
