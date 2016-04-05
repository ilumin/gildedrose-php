<?php

class ItemBackStage extends AbstractItem
{
    public $qualityDropRate = 1;

    public function getQualityDropRate()
    {
        if ($this->item->sell_in < 0) {
            return 0 * $this->qualityDropRate;
        }

        if ($this->item->sell_in < 5) {
            return 3 * $this->qualityDropRate;
        }

        if ($this->item->sell_in < 10) {
            return 2 * $this->qualityDropRate;
        }

        return parent::getQualityDropRate();
    }
}
