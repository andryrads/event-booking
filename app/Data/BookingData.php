<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class BookingData extends Data
{
    public function __construct(
        public int $quantity,
    ) {}
}
