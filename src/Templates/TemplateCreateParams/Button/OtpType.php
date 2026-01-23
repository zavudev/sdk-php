<?php

declare(strict_types=1);

namespace Zavudev\Templates\TemplateCreateParams\Button;

/**
 * Required when type is 'otp'. COPY_CODE shows copy button, ONE_TAP enables Android autofill.
 */
enum OtpType: string
{
    case COPY_CODE = 'COPY_CODE';

    case ONE_TAP = 'ONE_TAP';
}
