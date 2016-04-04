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
     * @Requirements At the end of each day our system lowers both values for every item
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
     * @Requirements Once the sell by date has passed, Quality degrades twice as fast
     */
    public function testQualityDegradesTwice()
    {
        $items = array(new Item("foo", 0, 10));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(-1, $items[0]->sell_in);
        $this->assertEquals(8, $items[0]->quality);
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

    /**
     * @Requirements "Aged Brie" actually increases in Quality the older it gets
     */
    public function testQualityIncreasesForAgedBrie()
    {
        $items = array(new Item("Aged Brie", 1, 0));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(0, $items[0]->sell_in);
        $this->assertEquals(1, $items[0]->quality);
    }

    /**
     * @Requirements The Quality of an item is never more than 50
     */
    public function testQualityNeverMoreThanFifty()
    {
        $items = array(new Item("Aged Brie", 1, 50));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(0, $items[0]->sell_in);
        $this->assertEquals(50, $items[0]->quality);
    }

    /**
     * @Requirements "Sulfuras", being a legendary item, never has to be sold or decreases in Quality
     */
    public function testQualitySulfurasNeverDecreases()
    {
        $items = array(new Item("Sulfuras, Hand of Ragnaros", 1, 80));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(1, $items[0]->sell_in);
        $this->assertEquals(80, $items[0]->quality);
    }

    /**
     * @Requirements "Backstage passes", like aged brie, increases in Quality as its SellIn value approaches
     */
    public function testQualityIncreaseForBackstage()
    {
        $items = array(new Item("Backstage passes to a TAFKAL80ETC concert", 20, 49));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(19, $items[0]->sell_in);
        $this->assertEquals(50, $items[0]->quality);
    }

    /**
     * @Requirements "Backstage passes" Quality increases by 2 when there are 10 days or less
     */
    public function testQualityIncrease2ForBackstage()
    {
        $items = array(new Item("Backstage passes to a TAFKAL80ETC concert", 10, 10));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(9, $items[0]->sell_in);
        $this->assertEquals(12, $items[0]->quality);
    }

    /**
     * @Requirements "Backstage passes" Quality increases by 3 when there are 5 days or less
     */
    public function testQualityIncrease3ForBackstage()
    {
        $items = array(new Item("Backstage passes to a TAFKAL80ETC concert", 5, 10));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(4, $items[0]->sell_in);
        $this->assertEquals(13, $items[0]->quality);
    }

    /**
     * @Requirements "Backstage passes" Quality drops to 0 after the concert
     */
    public function testQualityDropToZeroAfterConcert()
    {
        $items = array(new Item("Backstage passes to a TAFKAL80ETC concert", 0, 10));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(-1, $items[0]->sell_in);
        $this->assertEquals(0, $items[0]->quality);
    }

    /*
     * @Requirements "Conjured" items degrade in Quality twice as fast as normal items
     *
    public function testQualityDegradesTwiceForConjured()
    {
        $items = array(
            new Item("Conjured Mana Cake", 1, 10),
            new Item("Conjured Mana Cake", 0, 10),
        );
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(0, $items[0]->sell_in);
        $this->assertEquals(8, $items[0]->quality);
        $this->assertEquals(-1, $items[1]->sell_in);
        $this->assertEquals(6, $items[1]->quality);
    }

    */

    /**
     * Golden Master Test
     * Expected response to equal to fixture
     */
    public function testGoldenMaster()
    {
        ob_start();
        echo "OMGHAI!\n";

        $items = array(
            new Item('+5 Dexterity Vest', 10, 20),
            new Item('+5 Dexterity Vest', 0, 20),
            new Item('Aged Brie', 2, 0),
            new Item('Aged Brie', 6, 47),
            new Item('Elixir of the Mongoose', 5, 7),
            new Item('Sulfuras, Hand of Ragnaros', 0, 80),
            new Item('Sulfuras, Hand of Ragnaros', -1, 80),
            new Item('Backstage passes to a TAFKAL80ETC concert', 15, 49),
            new Item('Backstage passes to a TAFKAL80ETC concert', 10, 20),
            new Item('Backstage passes to a TAFKAL80ETC concert', 2, 10),
            // this conjured item does not work properly yet
            new Item('Conjured Mana Cake', 1, 20)
        );

        $app = new GildedRose($items);

        $days = 6;
        if (count($argv) > 1) {
            $days = (int) $argv[1];
        }

        for ($i = 0; $i < $days; $i++) {
            echo("-------- day $i --------\n");
            echo("name, sellIn, quality\n");
            foreach ($items as $item) {
                echo $item . PHP_EOL;
            }
            echo PHP_EOL;
            $app->update_quality();
        }
        $response = ob_get_contents();
        ob_end_clean();

        $fixture = file_get_contents('/app/test/fixture.txt');

        $this->assertEquals($fixture, $response);
    }
}
