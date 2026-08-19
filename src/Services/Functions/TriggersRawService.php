<?php

declare(strict_types=1);

namespace Zavudev\Services\Functions;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Functions\Triggers\TriggerCreateParams;
use Zavudev\Functions\Triggers\TriggerListResponse;
use Zavudev\Functions\Triggers\TriggerNewResponse;
use Zavudev\Functions\Triggers\TriggerUpdateParams;
use Zavudev\Functions\Triggers\TriggerUpdateResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Functions\TriggersRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class TriggersRawService implements TriggersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Subscribe a function to one or more event types, optionally scoped to specific senders. Provide eventTypes and senderIds (use null in senderIds for all senders); a trigger is created for each event type and sender combination.
     *
     * The special event type `cron` runs the function on a schedule instead of a messaging event: include a `cron` field with a 5-field UTC cron expression (minimum granularity one minute). A cron trigger ignores the sender axis, and a function may hold several cron triggers with different expressions. The function receives an event with `type: "cron"` and `data.cron`.
     *
     * @param string $functionID zavu Function ID
     * @param array{
     *   eventTypes: list<string>, senderIDs: list<string|null>, cron?: string
     * }|TriggerCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TriggerNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $functionID,
        array|TriggerCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TriggerCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/functions/%1$s/triggers', $functionID],
            body: (object) $parsed,
            options: $options,
            convert: TriggerNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Enable or disable a trigger
     *
     * @param array{active: bool}|TriggerUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TriggerUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $triggerID,
        array|TriggerUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TriggerUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/functions/triggers/%1$s', $triggerID],
            body: (object) $parsed,
            options: $options,
            convert: TriggerUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List function triggers
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TriggerListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/functions/%1$s/triggers', $functionID],
            options: $requestOptions,
            convert: TriggerListResponse::class,
        );
    }

    /**
     * @api
     *
     * Delete a trigger
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $triggerID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/functions/triggers/%1$s', $triggerID],
            options: $requestOptions,
            convert: null,
        );
    }
}
