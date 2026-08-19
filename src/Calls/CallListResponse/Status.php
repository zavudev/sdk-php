<?php

declare(strict_types=1);

namespace Zavudev\Calls\CallListResponse;

/**
 * Lifecycle status of a voice call.
 * - `queued`: outbound call created, not yet dialing.
 * - `ringing`: dialing (outbound) or received and ringing (inbound).
 * - `in_progress`: answered, the agent is connected.
 * - `completed`: ended after a conversation.
 * - `failed`: could not be completed.
 * - `busy`: the line was busy.
 * - `no_answer`: rang but was not answered.
 * - `canceled`: canceled before it was answered.
 */
enum Status: string
{
    case QUEUED = 'queued';

    case RINGING = 'ringing';

    case IN_PROGRESS = 'in_progress';

    case COMPLETED = 'completed';

    case FAILED = 'failed';

    case BUSY = 'busy';

    case NO_ANSWER = 'no_answer';

    case CANCELED = 'canceled';
}
