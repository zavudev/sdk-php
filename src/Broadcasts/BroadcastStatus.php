<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

/**
 * Current status of the broadcast.
 */
enum BroadcastStatus: string
{
    case DRAFT = 'draft';

    case PENDING_REVIEW = 'pending_review';

    case APPROVED = 'approved';

    case REJECTED = 'rejected';

    case ESCALATED = 'escalated';

    case REJECTED_FINAL = 'rejected_final';

    case SCHEDULED = 'scheduled';

    case SENDING = 'sending';

    case PAUSED = 'paused';

    case COMPLETED = 'completed';

    case CANCELLED = 'cancelled';

    case FAILED = 'failed';
}
