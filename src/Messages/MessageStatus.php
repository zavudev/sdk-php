<?php

declare(strict_types=1);

namespace Zavudev\Messages;

enum MessageStatus: string
{
    case QUEUED = 'queued';

    case SENDING = 'sending';

    case DELIVERED = 'delivered';

    case FAILED = 'failed';

    case RECEIVED = 'received';

    case PENDING_URL_VERIFICATION = 'pending_url_verification';
}
