<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Calls\CallCreateParams;
use Zavudev\Calls\CallGetResponse;
use Zavudev\Calls\CallHangupResponse;
use Zavudev\Calls\CallListParams;
use Zavudev\Calls\CallListParams\Direction;
use Zavudev\Calls\CallListParams\Status;
use Zavudev\Calls\CallListResponse;
use Zavudev\Calls\CallNewResponse;
use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\CallsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class CallsRawService implements CallsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Place an outbound voice call answered by the voice agent configured on the sender. Zavu dials the recipient and runs the conversation through its managed voice pipeline (speech recognition, the agent's LLM, and speech synthesis, with real-time interruption handling).
     *
     * **Requirements:**
     * - The Voice Agents feature must be enabled for your team (otherwise `403`).
     * - An account that has verified nothing may only call the phone numbers the project has verified (`403` with code `destination_not_verified`, and `details.verifiedNumbers` lists them), and at most 5 calls a day (`429` with code `daily_limit_exceeded`). A number is verified from the dashboard's Sandbox screen by sending the pre-filled WhatsApp message from that phone; the same verification covers SMS and calls. Verify your identity, add a payment method, settle a deposit or subscribe to call any destination. That raises the ceiling to 50 calls a day on Free; paid plans have no daily call ceiling. Full reference: https://docs.zavu.dev/concepts/sending-limits
     * - The sender's agent must have `voice.enabled` set to `true`.
     * - Not available with test-mode API keys.
     *
     * **Billing:** Voice calls are billed per minute of connected time plus telephony, deducted from your prepaid balance. A short-duration estimate is reserved when the call is placed; you are charged for the actual duration when the call ends.
     *
     * @param array{
     *   to: string,
     *   greeting?: string,
     *   language?: string,
     *   maxDurationMinutes?: int,
     *   metadata?: array<string,string>,
     *   senderID?: string,
     * }|CallCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CallNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|CallCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CallCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/calls',
            body: (object) $parsed,
            options: $options,
            convert: CallNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Retrieve a single voice call, including its full transcript once the conversation has produced turns.
     *
     * @param string $callID voice call ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CallGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $callID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/calls/%1$s', $callID],
            options: $requestOptions,
            convert: CallGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List voice calls for this project, most recent first. Transcripts are omitted from the list; fetch a single call to get its transcript.
     *
     * @param array{
     *   cursor?: string,
     *   direction?: Direction|value-of<Direction>,
     *   limit?: int,
     *   status?: value-of<Status>,
     * }|CallListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<CallListResponse>>
     *
     * @throws APIException
     */
    public function list(
        array|CallListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CallListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/calls',
            query: $parsed,
            options: $options,
            convert: CallListResponse::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * End an active voice call. The call must still be ringing or in progress. Not available with test-mode API keys.
     *
     * @param string $callID voice call ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CallHangupResponse>
     *
     * @throws APIException
     */
    public function hangup(
        string $callID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/calls/%1$s/hangup', $callID],
            options: $requestOptions,
            convert: CallHangupResponse::class,
        );
    }
}
