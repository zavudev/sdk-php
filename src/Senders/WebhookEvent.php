<?php

declare(strict_types=1);

namespace Zavudev\Senders;

/**
 * Type of event that triggers the webhook. Note: Reactions are delivered as message.inbound with messageType='reaction'.
 */
enum WebhookEvent: string
{
    case MESSAGE_QUEUED = 'message.queued';

    case MESSAGE_SENT = 'message.sent';

    case MESSAGE_DELIVERED = 'message.delivered';

    case MESSAGE_FAILED = 'message.failed';

    case MESSAGE_INBOUND = 'message.inbound';

    case MESSAGE_UNSUPPORTED = 'message.unsupported';

    case CONVERSATION_NEW = 'conversation.new';

    case TEMPLATE_STATUS_CHANGED = 'template.status_changed';
}
