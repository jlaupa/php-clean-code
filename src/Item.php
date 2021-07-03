<?php

namespace Runroom\GildedRose;

class Item {

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

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }

}
