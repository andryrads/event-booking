<?php

namespace App\Enums;

enum PaymentStatusEnum: string {
    case SUCCESS = 'success';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';
}
