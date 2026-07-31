<?php

declare(strict_types=1);

namespace Zavudev\Invitations\Invitation;

/**
 * Current status of the partner invitation.
 *
 * `failed` means the client started the connection and it did not finish (they cancelled Meta's dialog, denied a permission, or abandoned the tab). A failed invitation is still usable: the same link can be retried, and it moves back to `in_progress` when the client tries again.
 */
enum Status: string
{
    case PENDING = 'pending';

    case IN_PROGRESS = 'in_progress';

    case COMPLETED = 'completed';

    case EXPIRED = 'expired';

    case CANCELLED = 'cancelled';

    case FAILED = 'failed';
}
