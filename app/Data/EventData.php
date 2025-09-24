<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class EventData extends Data
{
    public function __construct(
        public string $title,
        public ?string $description,
        public string $date,
        public string $location,
    ) {}
}
