<?php

declare(strict_types=1);

namespace Zavudev\Senders;

/**
 * Type of event that triggers the webhook.
 *
 * **Message lifecycle events:**
 * - `message.queued`: Message created and queued for sending. `data.status` = `queued`
 * - `message.sent`: Message accepted by the provider. `data.status` = `sent`
 * - `message.delivered`: Message delivered to recipient. `data.status` = `delivered`
 * - `message.read`: Message was read by the recipient (WhatsApp only). `data.status` = `read`
 * - `message.failed`: Message failed to send. `data.status` = `failed`
 *
 * **Inbound events:**
 * - `message.inbound`: New message received from a contact. Reactions are delivered as `message.inbound` with `messageType='reaction'`
 * - `message.unsupported`: Received a message type that is not supported
 *
 * **Broadcast events:**
 * - `broadcast.status_changed`: Broadcast status changed (pending_review, approved, rejected, sending, completed, cancelled)
 *
 * **Other events:**
 * - `conversation.new`: New conversation started with a contact
 * - `template.status_changed`: WhatsApp template approval status changed
 *
 * **Partner events:**
 * - `invitation.status_changed`: A partner invitation status changed (pending, in_progress, completed, cancelled)
 */
enum WebhookEvent: string
{
    case MESSAGE_QUEUED = 'message.queued';

    case MESSAGE_SENT = 'message.sent';

    case MESSAGE_DELIVERED = 'message.delivered';

    case MESSAGE_READ = 'message.read';

    case MESSAGE_FAILED = 'message.failed';

    case MESSAGE_INBOUND = 'message.inbound';

    case MESSAGE_UNSUPPORTED = 'message.unsupported';

    case BROADCAST_STATUS_CHANGED = 'broadcast.status_changed';

    case CONVERSATION_NEW = 'conversation.new';

    case TEMPLATE_STATUS_CHANGED = 'template.status_changed';

    case INVITATION_STATUS_CHANGED = 'invitation.status_changed';
}
