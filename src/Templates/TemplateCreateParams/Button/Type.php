<?php

declare(strict_types=1);

namespace Zavudev\Templates\TemplateCreateParams\Button;

/**
 * `request_contact_info` renders a fixed **Share Contact Info** button that asks the recipient to share their phone number — useful when a contact adopted a WhatsApp username and you only know their BSUID. It takes no other fields.
 */
enum Type: string
{
    case QUICK_REPLY = 'quick_reply';

    case URL = 'url';

    case PHONE = 'phone';

    case OTP = 'otp';

    case REQUEST_CONTACT_INFO = 'request_contact_info';
}
