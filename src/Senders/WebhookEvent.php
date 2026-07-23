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
 * - `message.inbound`: New message received from a contact. `data.conversationId` is the inbox thread id (deep-link with `https://dashboard.zavu.dev/{locale}/inbox?conv={conversationId}`); it is `null` while the conversation row is still being created (the first message of a brand-new thread, or several near-simultaneous first messages), where `conversation.new` carries the id instead — `GET /v1/messages/{messageId}` always has it. Reactions are delivered as `message.inbound` with `messageType='reaction'`. When the contact replied to (quoted) an earlier message, `data.content` carries the reply context: `replyToMessageId`, `replyToProviderMessageId`, `replyToFrom`, `replyToText`, and `replyToMessageType`. `data.providerTimestamp` is the provider's original receive time in Unix milliseconds (the moment the channel received the message from the contact — WhatsApp, Telegram, Instagram, Messenger; `null` for SMS and email). Compare it against the top-level `timestamp` (when Zavu dispatched the webhook) to detect and ignore delayed deliveries.
 * - `message.unsupported`: Received a message type that is not supported
 *
 * **Broadcast events:**
 * - `broadcast.status_changed`: Broadcast status changed (pending_review, approved, rejected, sending, completed, cancelled)
 *
 * **Other events:**
 * - `conversation.new`: New conversation started with a contact. `data` carries `conversationId` (the inbox thread id — deep-link with `https://dashboard.zavu.dev/{locale}/inbox?conv={conversationId}`), the `phoneNumber` or `email` key, `channel`, `firstMessageId`, `firstMessageText`, and `profileName`.
 * - `template.status_changed`: WhatsApp template approval status changed
 *
 * **Partner events:**
 * - `invitation.status_changed`: A partner invitation status changed (pending, in_progress, completed, cancelled)
 *
 * **Custom domain events:**
 * - `domain.verified`: A custom email domain passed verification (DKIM, and SPF/DMARC/MAIL FROM if enhanced records are enabled)
 * - `domain.failed`: A custom email domain failed verification or is partially verified
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

    case DOMAIN_VERIFIED = 'domain.verified';

    case DOMAIN_FAILED = 'domain.failed';
}
