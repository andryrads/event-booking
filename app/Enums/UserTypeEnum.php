<?php

namespace App\Enums;

enum UserTypeEnum: string {
    case ADMIN = 'admin';
    case ORGANIZER = 'organizer';
    case CUSTOMER = 'customer';
}