<?php

declare(strict_types=1);

namespace Zavudev\Templates\Template\Button;

enum Type: string
{
    case QUICK_REPLY = 'quick_reply';

    case URL = 'url';

    case PHONE = 'phone';

    case OTP = 'otp';
}
