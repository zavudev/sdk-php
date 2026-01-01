<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts\BroadcastContact;

enum RecipientType: string
{
    case PHONE = 'phone';

    case EMAIL = 'email';
}
