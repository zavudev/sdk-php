<?php

declare(strict_types=1);

namespace Zavudev\Invitations\InvitationListParams;

/**
 * Current status of the partner invitation.
 */
enum Status: string
{
    case PENDING = 'pending';

    case IN_PROGRESS = 'in_progress';

    case COMPLETED = 'completed';

    case EXPIRED = 'expired';

    case CANCELLED = 'cancelled';
}
