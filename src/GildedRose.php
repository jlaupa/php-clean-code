<?php

namespace Runroom\GildedRose;

class GildedRose
{
    /**
     * @var Item[] $items
     */
    private array $items;

    /**
     * GildedRose constructor.
     * @param Item[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if ($item->name === Item::SULFURAS) {
                continue;
            }

            $item->qualityBackstageRules();
            $item->qualityAgeRules();
            $item->qualityOtherRules();
        }
    }
}
