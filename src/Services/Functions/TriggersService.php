<?php

declare(strict_types=1);

namespace Zavudev\Services\Functions;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Functions\Triggers\TriggerListResponse;
use Zavudev\Functions\Triggers\TriggerNewResponse;
use Zavudev\Functions\Triggers\TriggerUpdateResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Functions\TriggersContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class TriggersService implements TriggersContract
{
    /**
     * @api
     */
    public TriggersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TriggersRawService($client);
    }

    /**
     * @api
     *
     * Subscribe a function to one or more event types, optionally scoped to specific senders. Provide eventTypes and senderIds (use null in senderIds for all senders); a trigger is created for each event type and sender combination.
     *
     * The special event type `cron` runs the function on a schedule instead of a messaging event: include a `cron` field with a 5-field UTC cron expression (minimum granularity one minute). A cron trigger ignores the sender axis, and a function may hold several cron triggers with different expressions. The function receives an event with `type: "cron"` and `data.cron`.
     *
     * @param string $functionID zavu Function ID
     * @param list<string> $eventTypes event types to subscribe to
     * @param list<string|null> $senderIDs Senders to scope the triggers to. Use null for all senders.
     * @param string $cron required when eventTypes includes `cron`: a 5-field cron expression (minute hour day-of-month month day-of-week), evaluated in UTC
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $functionID,
        array $eventTypes,
        array $senderIDs,
        ?string $cron = null,
        RequestOptions|array|null $requestOptions = null,
    ): TriggerNewResponse {
        $params = Util::removeNulls(
            ['eventTypes' => $eventTypes, 'senderIDs' => $senderIDs, 'cron' => $cron]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($functionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Enable or disable a trigger
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $triggerID,
        bool $active,
        RequestOptions|array|null $requestOptions = null,
    ): TriggerUpdateResponse {
        $params = Util::removeNulls(['active' => $active]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($triggerID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List function triggers
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): TriggerListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($functionID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a trigger
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $triggerID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($triggerID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
