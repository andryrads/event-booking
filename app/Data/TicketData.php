<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class TicketData extends Data
{
    public function __construct(
        public string $type,
        public float $price,
        public int $quantity,
    ) {}
}