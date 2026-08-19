<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Calls\CallGetResponse;
use Zavudev\Calls\CallHangupResponse;
use Zavudev\Calls\CallListParams\Direction;
use Zavudev\Calls\CallListParams\Status;
use Zavudev\Calls\CallListResponse;
use Zavudev\Calls\CallNewResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface CallsContract
{
    /**
     * @api
     *
     * @param string $to Recipient phone number in E.164 format.
     * @param string $greeting overrides the agent's configured greeting for this call only
     * @param string $language Language the agent speaks on this call only, as a BCP-47 tag (`en`, `es`, `es-ES`, `pt-BR`), or `auto` to detect the caller's language and follow it. Overrides the agent's configured language for speech recognition, the agent's replies, and the synthesized voice. If the agent uses a custom voice you supplied, that voice is kept and only the language changes. When omitted, the agent's configured language is used.
     * @param int $maxDurationMinutes overrides the agent's maximum call duration for this call only
     * @param array<string,string> $metadata Arbitrary metadata to associate with the call. Returned on the call object and included in voice webhooks.
     * @param string $senderID Sender profile that places the call. Uses the project's default sender if omitted. The sender's agent must have voice enabled.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $to,
        ?string $greeting = null,
        ?string $language = null,
        ?int $maxDurationMinutes = null,
        ?array $metadata = null,
        ?string $senderID = null,
        RequestOptions|array|null $requestOptions = null,
    ): CallNewResponse;

    /**
     * @api
     *
     * @param string $callID voice call ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $callID,
        RequestOptions|array|null $requestOptions = null
    ): CallGetResponse;

    /**
     * @api
     *
     * @param Direction|value-of<Direction> $direction whether the call was placed by Zavu (outbound) or received from a caller (inbound)
     * @param Status|value-of<Status> $status Lifecycle status of a voice call.
     * - `queued`: outbound call created, not yet dialing.
     * - `ringing`: dialing (outbound) or received and ringing (inbound).
     * - `in_progress`: answered, the agent is connected.
     * - `completed`: ended after a conversation.
     * - `failed`: could not be completed.
     * - `busy`: the line was busy.
     * - `no_answer`: rang but was not answered.
     * - `canceled`: canceled before it was answered.
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<CallListResponse>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        Direction|string|null $direction = null,
        int $limit = 50,
        Status|string|null $status = null,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param string $callID voice call ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function hangup(
        string $callID,
        RequestOptions|array|null $requestOptions = null
    ): CallHangupResponse;
}
