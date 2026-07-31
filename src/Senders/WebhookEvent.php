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
 * - `invitation.status_changed`: A partner invitation status changed (pending, in_progress, completed, cancelled, failed). `data` carries `invitationId`, `clientName`, `clientEmail`, `connectionType` (`whatsapp_waba` or `messenger`), `previousStatus`, and `currentStatus`. On `completed` it also carries `senderId` and `connectedAccount` (`channel`, `id`, `name`) — the WhatsApp number or Facebook Page that was linked. On `failed` it carries `failureReason`; the invitation link stays usable, so a client can retry it.
 *
 * **Voice Agent events:**
 * For every voice event, `data` carries `callId`, `direction`, `from`, `to`, `status`, `durationSeconds`, `endReason`, and `transcriptAvailable`. The terminal events (`call.completed`, `call.failed`) additionally carry `cost` — what the call was billed, in USD, combining telephony and the managed voice pipeline — and `currency`. They are dispatched after the call is charged, so `cost` is populated rather than zero; telephony can still be settling on an outbound call, in which case `GET /v1/calls/{callId}` holds the reconciled figure.
 * - `call.initiated`: An outbound call was created and is dialing, or an inbound call was received. `data.status` = `ringing`
 * - `call.answered`: The call was answered and the voice agent is connected. `data.status` = `in_progress`
 * - `call.completed`: The call ended after a conversation. `data.status` = `completed`; `durationSeconds` and `endReason` describe how it ended, and `transcriptAvailable` indicates whether a transcript can be fetched.
 * - `call.failed`: The call could not be completed (busy, no answer, canceled, or an error). `data.status` is the terminal status and `endReason` explains the cause.
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

    case MESSAGE_STATUS = 'message.status';

    case MESSAGE_FAILED = 'message.failed';

    case MESSAGE_INBOUND = 'message.inbound';

    case MESSAGE_UNSUPPORTED = 'message.unsupported';

    case BROADCAST_STATUS_CHANGED = 'broadcast.status_changed';

    case CONVERSATION_NEW = 'conversation.new';

    case TEMPLATE_STATUS_CHANGED = 'template.status_changed';

    case INVITATION_STATUS_CHANGED = 'invitation.status_changed';

    case CALL_INITIATED = 'call.initiated';

    case CALL_ANSWERED = 'call.answered';

    case CALL_COMPLETED = 'call.completed';

    case CALL_FAILED = 'call.failed';

    case DOMAIN_VERIFIED = 'domain.verified';

    case DOMAIN_FAILED = 'domain.failed';
}
