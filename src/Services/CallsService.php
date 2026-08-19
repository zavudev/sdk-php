<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Calls\CallGetResponse;
use Zavudev\Calls\CallHangupResponse;
use Zavudev\Calls\CallListParams\Direction;
use Zavudev\Calls\CallListParams\Status;
use Zavudev\Calls\CallListResponse;
use Zavudev\Calls\CallNewResponse;
use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\CallsContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class CallsService implements CallsContract
{
    /**
     * @api
     */
    public CallsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CallsRawService($client);
    }

    /**
     * @api
     *
     * Place an outbound voice call answered by the voice agent configured on the sender. Zavu dials the recipient and runs the conversation through its managed voice pipeline (speech recognition, the agent's LLM, and speech synthesis, with real-time interruption handling).
     *
     * **Requirements:**
     * - The Voice Agents feature must be enabled for your team (otherwise `403`).
     * - The sender's agent must have `voice.enabled` set to `true`.
     * - Not available with test-mode API keys.
     *
     * **Billing:** Voice calls are billed per minute of connected time plus telephony, deducted from your prepaid balance. A short-duration estimate is reserved when the call is placed; you are charged for the actual duration when the call ends.
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
    ): CallNewResponse {
        $params = Util::removeNulls(
            [
                'to' => $to,
                'greeting' => $greeting,
                'language' => $language,
                'maxDurationMinutes' => $maxDurationMinutes,
                'metadata' => $metadata,
                'senderID' => $senderID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieve a single voice call, including its full transcript once the conversation has produced turns.
     *
     * @param string $callID voice call ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $callID,
        RequestOptions|array|null $requestOptions = null
    ): CallGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($callID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List voice calls for this project, most recent first. Transcripts are omitted from the list; fetch a single call to get its transcript.
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
    ): Cursor {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'direction' => $direction,
                'limit' => $limit,
                'status' => $status,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * End an active voice call. The call must still be ringing or in progress. Not available with test-mode API keys.
     *
     * @param string $callID voice call ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function hangup(
        string $callID,
        RequestOptions|array|null $requestOptions = null
    ): CallHangupResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->hangup($callID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
