<?php

declare(strict_types=1);

namespace Zavudev\Templates\Template\Button;

/**
 * OTP button type. Required when type is 'otp'.
 */
enum OtpType: string
{
    case COPY_CODE = 'COPY_CODE';

    case ONE_TAP = 'ONE_TAP';
}
