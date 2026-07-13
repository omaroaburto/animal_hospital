<?php

namespace App\Domains\Clients\Enums;

enum DocumentType: string
{
    case RUT = 'rut';
    case PASSPORT = 'passport';
}
