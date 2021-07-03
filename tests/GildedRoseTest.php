<?php

namespace Runroom\GildedRose\Tests;

use PHPUnit\Framework\TestCase;
use Runroom\GildedRose\GildedRose;
use Runroom\GildedRose\Item;

class GildedRoseTest extends TestCase
{
    /**
     * @test
     */
    public function itemsDegradeQuality(): void
    {
        $item = new Item('', 1, 5);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        self::assertEquals(4, $item->quality);
  	}

    /**
     * @test
     */
    public function itemsDegradeDoubleQualityOnceTheSellInDateHasPass(): void
    {
        $item = new Item('', -1, 5);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        self::assertEquals(3, $item->quality);
  	}

    /**
     * @test
     */
    public function itemsCannotHaveNegativeQuality(): void
    {
        $item = new Item('', 0, 0);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        self::assertEquals(0, $item->quality);
  	}

    /**
     * @test
     */
    public function agedBrieIncreasesQualityOverTime(): void
    {
        $item = new Item(Item::AGED, 0, 5);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        self::assertEquals(7, $item->quality);
  	}

    /**
     * @test
     */
    public function qualityCannotBeGreaterThan50(): void
    {
        $item = new Item(Item::AGED, 0, 50);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        self::assertEquals(50, $item->quality);
  	}

    /**
     * @test
     */
    public function sulfurasDoesNotChange(): void
    {
        $item = new Item(Item::SULFURAS, 10, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        self::assertEquals(10, $item->sell_in);
        self::assertEquals(10, $item->quality);
  	}

    /**
     * @return int[][]
     */
    public static function backstageRules(): array
    {
  		return [
  			'incr. 1 if sellIn > 10' => [11, 10, 11],
  			'incr. 2 if 5 < sellIn <= 10 (max)' => [10, 10, 12],
  			'incr. 2 if 5 < sellIn <= 10 (min)' => [6, 10, 12],
  			'incr. 3 if 0 < sellIn <= 5 (max)' => [5, 10, 13],
  			'incr. 3 if 0 < sellIn <= 5 (min)' => [1, 10, 13],
  			'puts to 0 if sellIn <= 0 (max)' => [0, 10, 0],
  			'puts to 0 if sellIn <= 0 (...)' => [-1, 10, 0],
  		];
  	}

    /**
     * @dataProvider backstageRules
     * @test
     * @param int $sellIn
     * @param int $quality
     * @param int $expected
     */
    public function backstageQualityIncreaseOverTimeWithCertainRules(int $sellIn, int $quality, int $expected): void
    {
        $item = new Item(Item::BACKSTAGE, $sellIn, $quality);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        self::assertEquals($expected, $item->quality);
  	}
}
