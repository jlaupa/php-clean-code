<?php

namespace Runroom\GildedRose;

class Item
{
    public const AGED = 'Aged Brie';
    public const BACKSTAGE = 'Backstage passes to a TAFKAL80ETC concert';
    public const SULFURAS = 'Sulfuras, Hand of Ragnaros';

    /**
     * @var string $name
     */
    public string $name;

    /**
     * @var int $sell_in
     */
    public int $sell_in;

    /**
     * @var int $quality
     */
    public int $quality;

    /**
     * Item constructor.
     * @param string $name
     * @param int $sellIn
     * @param int $quality
     */
    public function __construct(string $name, int $sellIn, int $quality)
    {
        $this->name = $name;
        $this->sell_in = $sellIn;
        $this->quality = $quality;
    }

    public function qualityBackstageRules(): void
    {
        if (($this->name === self::BACKSTAGE) && !$this->qualityClean($this->sell_in)) {
            $this->qualityIncrease(3);
            if ($this->sell_in > 5) {
                $this->qualityDecrease();
                if ($this->sell_in > 10) {
                    $this->qualityDecrease();
                }
            }
        }
    }

    public function qualityAgeRules(): void
    {
        if (($this->name === self::AGED) && $this->quality < 50) {
            $this->qualityIncrease(2);
        }
    }

    public function qualityOtherRules(): void
    {
        if ($this->name !== self::BACKSTAGE && $this->name !== self::AGED) {
            $this->qualityDecrease();
            if ($this->sell_in <= 0) {
                $this->qualityDecrease();
                $this->qualityClean($this->quality);
            }
        }
    }

    /**
     * @param int $value
     * @return bool
     */
    public function qualityClean(int $value): bool
    {
        $condition = $value <= 0;
        if ($condition) {
            $this->quality = 0;
        }

        return $condition;
    }

    /**
     * @param int $value
     */
    public function qualityIncrease(int $value = 1): void
    {
        $this->quality += $value;
    }

    /**
     * @param int $value
     */
    public function qualityDecrease(int $value = 1): void
    {
        $this->quality -= $value ;
    }
}
