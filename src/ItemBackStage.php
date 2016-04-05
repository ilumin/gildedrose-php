<?php

class ItemBackStage extends AbstractItem
{
    const QUALITY_DROP_RATE = 1;

    public function getQualityDropRate()
    {
        if ($this->sell_in < 0) {
            return 0 * $this->dropRate;
        }

        if ($this->sell_in < 5) {
            return 3 * $this->dropRate;
        }

        if ($this->sell_in < 10) {
            return 3 * $this->dropRate;
        }

        return parent::getQualityDropRate();
    }
}
