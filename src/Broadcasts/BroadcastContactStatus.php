<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

/**
 * Status of a contact within a broadcast.
 *
 * - `pending`, `queued`, `sending`: not handed to the provider yet.
 * - `sent`: accepted by the provider; delivery is not confirmed yet. Channels that never report delivery leave the recipient here.
 * - `delivered`: the channel confirmed delivery to the device. A WhatsApp read receipt also counts as delivered.
 * - `failed`: not delivered. A recipient can move from `sent` or `delivered` to `failed` when the provider reports a failure late.
 * - `skipped`: not sent, because the recipient opted out of the channel or the broadcast was cancelled before reaching it.
 */
enum BroadcastContactStatus: string
{
    case PENDING = 'pending';

    case QUEUED = 'queued';

    case SENDING = 'sending';

    case SENT = 'sent';

    case DELIVERED = 'delivered';

    case FAILED = 'failed';

    case SKIPPED = 'skipped';
}
