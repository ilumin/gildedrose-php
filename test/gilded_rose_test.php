<?php

require_once 'gilded_rose.php';

class GildedRoseTest extends PHPUnit_Framework_TestCase {

    function testFoo() {
        $items = array(new Item("foo", 0, 0));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals("foo", $items[0]->name);
    }

    /**
     * @Requirements Once the sell by date has passed, Quality degrades twice as fast
     */
    public function testQualityDegrades()
    {
        $items = array(new Item("foo", 1, 10));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(0, $items[0]->sell_in);
        $this->assertEquals(9, $items[0]->quality);
    }

    /**
     * @Requirements The Quality of an item is never negative
     */
    public function testQualityNeverNegative()
    {
        $items = array(new Item("foo", 1, 0));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(0, $items[0]->quality);
    }

}
