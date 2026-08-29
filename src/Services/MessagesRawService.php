<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Messages\Message;
use Zavudev\Messages\MessageContent;
use Zavudev\Messages\MessageListAttachmentsResponse;
use Zavudev\Messages\MessageListParams;
use Zavudev\Messages\MessageListParams\Channel;
use Zavudev\Messages\MessageListParams\Status;
use Zavudev\Messages\MessageReactParams;
use Zavudev\Messages\MessageResponse;
use Zavudev\Messages\MessageSendParams;
use Zavudev\Messages\MessageSendParams\Attachment;
use Zavudev\Messages\MessageShowTypingParams;
use Zavudev\Messages\MessageShowTypingResponse;
use Zavudev\Messages\MessageType;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\MessagesRawContract;

/**
 * @phpstan-import-type AttachmentShape from \Zavudev\Messages\MessageSendParams\Attachment
 * @phpstan-import-type MessageContentShape from \Zavudev\Messages\MessageContent
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class MessagesRawService implements MessagesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get message by ID
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/%1$s', $messageID],
            options: $requestOptions,
            convert: MessageResponse::class,
        );
    }

    /**
     * @api
     *
     * List messages previously sent by this project.
     *
     * @param array{
     *   channel?: value-of<Channel>,
     *   cursor?: string,
     *   limit?: int,
     *   status?: Status|value-of<Status>,
     *   to?: string,
     * }|MessageListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Message>>
     *
     * @throws APIException
     */
    public function list(
        array|MessageListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/messages',
            query: $parsed,
            options: $options,
            convert: Message::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * List the stored file attachments for an email message and get a short-lived signed `downloadUrl` for each. Works for both inbound emails (received via `message.inbound`) and outbound emails you sent with attachments. Messages without stored attachments (including SMS, WhatsApp, and other channels) return an empty list. Each `downloadUrl` is generated fresh per request and expires — fetch the file promptly and do not cache the URL.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageListAttachmentsResponse>
     *
     * @throws APIException
     */
    public function listAttachments(
        string $messageID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/%1$s/attachments', $messageID],
            options: $requestOptions,
            convert: MessageListAttachmentsResponse::class,
        );
    }

    /**
     * @api
     *
     * Send an emoji reaction to an existing WhatsApp message. Reactions are only supported for WhatsApp messages.
     *
     * @param string $messageID Path param
     * @param array{emoji: string, zavuSender?: string}|MessageReactParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageResponse>
     *
     * @throws APIException
     */
    public function react(
        string $messageID,
        array|MessageReactParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageReactParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['zavuSender' => 'Zavu-Sender'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/messages/%1$s/reactions', $messageID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: MessageResponse::class,
        );
    }

    /**
     * @api
     *
     * Send a message to a recipient via SMS or WhatsApp.
     *
     * **Channel selection:**
     * - If `channel` is omitted and `messageType` is `text`, defaults to SMS
     * - If `messageType` is anything other than `text`, WhatsApp is used automatically
     *
     * **WhatsApp 24-hour window:**
     * - Free-form messages (non-template) require an open 24h window
     * - Window opens when the user messages you first
     * - Use template messages to initiate conversations outside the window
     *
     * **Plan allowances and email billing:**
     * - WhatsApp, Telegram, Instagram and Messenger share an allowance of 2,000 messages per month on Free. Over it, sends return 429 with code `a2p_limit_exceeded` and upgrade details; the counter resets on the 1st of each month. Paid plans have no message caps
     * - Email is billed from your prepaid balance in 1,000-message blocks: $0.40 per 1,000 transactional emails, $0.80 per 1,000 marketing (broadcast) emails. A block is charged when your monthly count crosses each 1,000 boundary, and at zero balance email sends return 402 with code `insufficient_balance`. Free teams start with $2 of credit and additionally cap at 3,000 emails/month and 100/day. Teams on earlier plans keep their original email quotas instead
     * - SMS and voice are billed per message from your balance on every plan
     *
     * **Account verification and daily limits:**
     * - A brand-new account can send on every channel immediately, but `sms`, `sms_oneway` and `voice` reach only the phone numbers the project has verified. Sending elsewhere returns `403` with code `destination_not_verified`; `details.verifiedNumbers` lists the numbers that are reachable. A number is verified from the dashboard's Sandbox screen: generate a code and send the pre-filled WhatsApp message from that phone to Zavu's sandbox number. One verification covers WhatsApp, SMS and calls, up to 5 numbers per project. To send to any destination, do any one of these: verify your identity, add a payment method, settle a deposit, or subscribe to a paid plan. Business verification (KYB) is never required to send
     * - Daily ceilings apply per channel group and rise with verification. An account that has verified nothing: 25/day across `sms` + `sms_oneway`, 5/day for `voice`, 100/day across WhatsApp, Telegram, Instagram and Messenger combined. Past that floor: 200/day for SMS, or 10,000/day once identity or business verification is approved (or a higher limit agreed for your account); 50/day voice and 250/day conversational on Free. **Paid plans have no voice or conversational daily ceiling.** Over a ceiling, sends return `429` with code `daily_limit_exceeded` and `details.limit`; the count resets at 00:00 UTC
     * - The daily ceiling never reduces the monthly allowance: 100/day on the conversational group still reaches the 2,000 monthly A2P messages Free includes
     * - Email needs no account verification here: a sender with a verified domain sends from day one, within the plan quota (100/day and 3,000/month on Free). Over the daily quota it returns `429` with code `daily_limit_exceeded`. Email broadcasts are the exception: they need the account past the sandbox level, see `POST /v1/broadcasts/{broadcastId}/send`
     * - Full reference: https://docs.zavu.dev/concepts/sending-limits
     *
     * **Email recipient pre-flight:**
     * Email messages are validated automatically before dispatch. Sends that would be a guaranteed hard bounce are failed instead of sent, protecting your bounce rate: the message transitions to `failed` (visible via `GET /v1/messages/{messageId}` and the `message.failed` webhook) with `errorCode` set to `EMAIL_INVALID_RECIPIENT` (malformed address), `EMAIL_DOMAIN_NOT_FOUND` (recipient domain has no MX or A records), or `EMAIL_RECIPIENT_SUPPRESSED` (address is on your suppression list after a previous bounce or complaint). Advisory signals (role addresses, disposable domains) do not block sends — check them beforehand with `POST /v1/introspect/email`.
     *
     * @param array{
     *   to: string,
     *   attachments?: list<Attachment|AttachmentShape>,
     *   channel?: value-of<\Zavudev\Messages\Channel>,
     *   content?: MessageContent|MessageContentShape,
     *   fallbackEnabled?: bool,
     *   htmlBody?: string,
     *   idempotencyKey?: string,
     *   messageType?: value-of<MessageType>,
     *   metadata?: array<string,string>,
     *   replyTo?: string,
     *   subject?: string,
     *   text?: string,
     *   voiceLanguage?: string,
     *   zavuSender?: string,
     * }|MessageSendParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageResponse>
     *
     * @throws APIException
     */
    public function send(
        array|MessageSendParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageSendParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['zavuSender' => 'Zavu-Sender'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: MessageResponse::class,
        );
    }

    /**
     * @api
     *
     * Mark an inbound WhatsApp message as read and display a typing indicator to the user while you prepare a response. The indicator is automatically dismissed when you send a reply, or after 25 seconds — whichever comes first. Only valid for inbound WhatsApp messages. Use this when a reply will take more than a couple of seconds (LLM agent, tool call, lookup) to improve the recipient's experience.
     *
     * @param array{zavuSender?: string}|MessageShowTypingParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageShowTypingResponse>
     *
     * @throws APIException
     */
    public function showTyping(
        string $messageID,
        array|MessageShowTypingParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageShowTypingParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/messages/%1$s/typing', $messageID],
            headers: Util::array_transform_keys(
                $parsed,
                ['zavuSender' => 'Zavu-Sender']
            ),
            options: $options,
            convert: MessageShowTypingResponse::class,
        );
    }
}
